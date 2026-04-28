<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$svc = app(App\Services\TernakMutationService::class);
$mutasi = App\Models\MutasiTernak::find(8); // The one we just created with 3
$mutasiData = array_merge(
    ['tanggal' => '2026-04-24', 'tahun' => '2026', 'jenis_mutasi' => 'kelahiran', 'peternak_id' => 5],
    App\Support\MutasiSchema::fillAnimalData('kelahiran', ['sapi_jantan' => 4])
);
$res = $svc->update($mutasi, $mutasiData);
echo json_encode($res->toArray());
