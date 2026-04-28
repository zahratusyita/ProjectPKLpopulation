<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ternaks = App\Models\Ternak::all();
$negatives = [];
foreach ($ternaks as $t) {
    foreach ($t->getAttributes() as $k => $v) {
        if (is_numeric($v) && $v < 0) {
            $negatives[] = "Peternak ID: {$t->peternak_id}, Column: {$k}, Value: {$v}";
        }
    }
}
echo "Negatives found:\n" . implode("\n", $negatives) . "\n";
