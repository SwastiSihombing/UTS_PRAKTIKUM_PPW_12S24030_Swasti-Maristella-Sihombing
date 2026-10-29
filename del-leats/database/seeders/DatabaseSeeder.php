<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $srv = Category::create(['name' => 'Server & Cloud',       'code' => 'SRV']);
        $iot = Category::create(['name' => 'Internet of Things',   'code' => 'IOT']); 
        $drn = Category::create(['name' => 'Multimedia & Drone',   'code' => 'DRN']); 

        $data = [
            [$srv->id, 'EQ-SRV-001', 'Komputer', 'Lenovo, Hitam', 'baik', 'dipinjam', 75000],
            [$srv->id, 'EQ-SRV-002', 'Hardisk', 'Robot, Biru', 'rusak_ringan', 'dalam_perbaikan', 40000],
            [$iot->id, 'EQ-IOT-001', 'Mouse', 'Lenovo, Hitam', 'baik', 'tersedia', 10000],
            [$iot->id, 'EQ-IOT-002', 'Kabel Lan', 'Mitosida, Putih', 'baik', 'tersedia', 8000],
            [$drn->id, 'EQ-DRN-001', 'CPU', 'Thinkpad, Hitam', 'baik', 'tersedia', 50000],
            [$drn->id, 'EQ-DRN-002', 'Camera', 'Canon, Hitam', 'dalam_perbaikan', 30000],
        ];

        foreach ($data as [$cat, $code, $name, $spec, $cond, $status, $fee]) {
            Equipment::create([
                'category_id' => $cat, 'asset_code' => $code, 'name' => $name,
                'specification' => $spec, 'condition' => $cond, 'status' => $status,
                'daily_rental_fee' => $fee, 'image_path' => null,
            ]);
        }
    }
}