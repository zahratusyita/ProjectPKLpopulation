<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LegacyDemoSeeder extends Seeder
{
    /**
     * Keep a dedicated entry point for demo data.
     */
    public function run(): void
    {
        $this->call(DemoPeternakanSeeder::class);
    }
}
