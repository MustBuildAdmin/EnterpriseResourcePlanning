<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrawingTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['drawing_types' => 'Tender/Contract',  'created_at' => now(), 'updated_at' => now()],
            ['drawing_types' => 'Consultant issued', 'created_at' => now(), 'updated_at' => now()],
            ['drawing_types' => 'As Built/Main Contractor submitted', 'created_at' => now(), 'updated_at' => now()],
            ['drawing_types' => 'Shop Drawings', 'created_at' => now(), 'updated_at' => now()] ];
        DB::table('drawing_types')->insert($data);
    }
}
