<?php

namespace App\Services;

use App\Models\MutasiTernak;
use App\Models\Ternak;
use App\Support\MutasiSchema;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TernakMutationService
{
    public function create(array $mutasiData): MutasiTernak
    {
        return DB::transaction(function () use ($mutasiData) {
            $mutasiData['applied_to_ternak'] = false;
            $mutasi = MutasiTernak::create($mutasiData);
            $this->applyMutation($mutasi, 1);
            $mutasi->applied_to_ternak = true;
            $mutasi->save();

            return $mutasi;
        });
    }

    public function update(MutasiTernak $mutasi, array $mutasiData): MutasiTernak
    {
        return DB::transaction(function () use ($mutasi, $mutasiData) {
            $previous = clone $mutasi;

            if ($previous->applied_to_ternak) {
                $this->applyMutation($previous, -1);
            }

            $mutasi->fill($mutasiData);
            $mutasi->applied_to_ternak = false;
            $mutasi->save();

            $this->applyMutation($mutasi, 1);
            $mutasi->applied_to_ternak = true;
            $mutasi->save();

            return $mutasi;
        });
    }

    public function delete(MutasiTernak $mutasi): void
    {
        DB::transaction(function () use ($mutasi) {
            if ($mutasi->applied_to_ternak) {
                $this->applyMutation($mutasi, -1);
            }

            $mutasi->delete();
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

            if ($next < 0) {
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

    private function directionForJenis(string $jenis): int
    {
        return $jenis === 'kelahiran' ? 1 : -1;
    }
}
