<?php

namespace App\Services;

use App\Models\MutasiTernak;
use App\Models\Peternak;
use App\Models\Ternak;
use App\Models\Verifikasi;
use App\Support\MutasiSchema;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TernakMutationService
{
    public function create(array $mutasiData): MutasiTernak
    {
        return DB::transaction(function () use ($mutasiData) {
            $wasCountyVerified = $this->isCountyVerifiedTarget(
                (int) $mutasiData['peternak_id'],
                (int) $mutasiData['tahun']
            );
            $mutasiData['applied_to_ternak'] = false;
            $mutasi = MutasiTernak::create($mutasiData);
            $this->applyMutation($mutasi, 1);
            $mutasi->applied_to_ternak = true;
            $mutasi->save();

            if ($wasCountyVerified) {
                $this->requireCountyReverificationForTarget(
                    (int) $mutasi->peternak_id,
                    (int) $mutasi->tahun
                );
            }

            return $mutasi;
        });
    }

    public function update(MutasiTernak $mutasi, array $mutasiData): MutasiTernak
    {
        return DB::transaction(function () use ($mutasi, $mutasiData) {
            $previous = clone $mutasi;
            $populationChanged = ! $previous->applied_to_ternak
                || $this->populationMutationChanged($previous, $mutasiData);
            $verifiedTargets = [];

            if ($populationChanged) {
                foreach ([
                    [(int) $previous->peternak_id, (int) $previous->tahun],
                    [(int) $mutasiData['peternak_id'], (int) $mutasiData['tahun']],
                ] as [$peternakId, $tahun]) {
                    if ($this->isCountyVerifiedTarget($peternakId, $tahun)) {
                        $verifiedTargets[$peternakId.'-'.$tahun] = [$peternakId, $tahun];
                    }
                }
            }

            $sameTarget = (int) $previous->peternak_id === (int) $mutasiData['peternak_id']
                && (int) $previous->tahun === (int) $mutasiData['tahun'];

            if ($previous->applied_to_ternak && $sameTarget && $populationChanged) {
                $this->replaceMutationOnSameTarget($previous, $mutasiData);
            } elseif ($previous->applied_to_ternak) {
                $this->applyMutation($previous, -1);
            }

            $mutasi->fill($mutasiData);
            $mutasi->applied_to_ternak = false;
            $mutasi->save();

            if (! $previous->applied_to_ternak || ! $sameTarget) {
                $this->applyMutation($mutasi, 1);
            }
            $mutasi->applied_to_ternak = true;
            $mutasi->save();

            foreach ($verifiedTargets as [$peternakId, $tahun]) {
                $this->requireCountyReverificationForTarget($peternakId, $tahun);
            }

            return $mutasi;
        });
    }

    public function delete(MutasiTernak $mutasi): void
    {
        DB::transaction(function () use ($mutasi) {
            $populationChanged = (bool) $mutasi->applied_to_ternak;
            $wasCountyVerified = $populationChanged && $this->isCountyVerifiedTarget(
                    (int) $mutasi->peternak_id,
                    (int) $mutasi->tahun
                );

            if ($mutasi->applied_to_ternak) {
                $this->applyMutation($mutasi, -1);
            }

            $mutasi->delete();

            if ($wasCountyVerified) {
                $this->requireCountyReverificationForTarget(
                    (int) $mutasi->peternak_id,
                    (int) $mutasi->tahun
                );
            }
        });
    }

    public function upsert(string $jenis, array $lookup, array $mutasiData): MutasiTernak
    {
        $existing = MutasiTernak::where($lookup)->first();
        $payload = array_merge($mutasiData, $lookup, ['jenis_mutasi' => $jenis]);

        if ($existing) {
            return $this->update($existing, $payload);
        }

        return $this->create($payload);
    }

    private function applyMutation(MutasiTernak $mutasi, int $mode): void
    {
        $multiplier = $this->directionForJenis($mutasi->jenis_mutasi) * $mode;
        $ternak = Ternak::firstOrNew([
            'tahun' => $mutasi->tahun,
            'peternak_id' => $mutasi->peternak_id,
        ]);

        foreach (MutasiSchema::animalColumns() as $column) {
            $current = (int) ($ternak->{$column} ?? 0);
            $delta = (int) ($mutasi->{$column} ?? 0) * $multiplier;
            $next = $current + $delta;

            if ($next < 0 && $delta < 0) {
                throw ValidationException::withMessages([
                    $column => 'Stok ternak tidak mencukupi untuk memproses mutasi pada kolom '.$column.'.',
                ]);
            }

            $ternak->{$column} = $next;
        }

        if (! $ternak->exists) {
            $ternak->keterangan = $ternak->keterangan ?? null;
        }

        $ternak->save();
    }

    private function replaceMutationOnSameTarget(MutasiTernak $previous, array $mutasiData): void
    {
        $ternak = Ternak::where('tahun', $previous->tahun)
            ->where('peternak_id', $previous->peternak_id)
            ->lockForUpdate()
            ->firstOrFail();

        $oldDirection = $this->directionForJenis($previous->jenis_mutasi);
        $newDirection = $this->directionForJenis($mutasiData['jenis_mutasi']);

        foreach (MutasiSchema::animalColumns() as $column) {
            $current = (int) ($ternak->{$column} ?? 0);
            $oldEffect = (int) ($previous->{$column} ?? 0) * $oldDirection;
            $newEffect = (int) ($mutasiData[$column] ?? 0) * $newDirection;
            $next = $current - $oldEffect + $newEffect;

            if ($next < 0) {
                throw ValidationException::withMessages([
                    $column => 'Stok ternak tidak mencukupi untuk memproses mutasi pada kolom '.$column.'.',
                ]);
            }

            $ternak->{$column} = $next;
        }

        $ternak->save();
    }

    private function directionForJenis(string $jenis): int
    {
        return $jenis === 'kelahiran' ? 1 : -1;
    }

    private function isCountyVerifiedTarget(int $peternakId, int $tahun): bool
    {
        return Ternak::where('peternak_id', $peternakId)
            ->where('tahun', $tahun)
            ->where('status_pengajuan', 2)
            ->exists();
    }

    private function populationMutationChanged(MutasiTernak $previous, array $mutasiData): bool
    {
        if (
            (int) $previous->peternak_id !== (int) $mutasiData['peternak_id'] ||
            (int) $previous->tahun !== (int) $mutasiData['tahun'] ||
            $previous->jenis_mutasi !== $mutasiData['jenis_mutasi']
        ) {
            return true;
        }

        foreach (MutasiSchema::animalColumns() as $column) {
            if ((int) $previous->{$column} !== (int) ($mutasiData[$column] ?? 0)) {
                return true;
            }
        }

        return false;
    }

    private function requireCountyReverificationForTarget(int $peternakId, int $tahun): void
    {
        $updated = Ternak::where('peternak_id', $peternakId)
            ->where('tahun', $tahun)
            ->where('status_pengajuan', 2)
            ->update(['status_pengajuan' => 3]);

        if ($updated === 0) {
            return;
        }

        $kabKotaId = Peternak::whereKey($peternakId)->value('kab_kota_id');

        if ($kabKotaId !== null) {
            Verifikasi::invalidateProvincialApproval((int) $kabKotaId, $tahun);
        }
    }
}
