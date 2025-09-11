<?php
namespace Database\Seeders;

use App\Models\MaterialType;
use Illuminate\Database\Seeder;

class MaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MaterialType::create([
            "name" => "Books",
        ]);
        MaterialType::create([
            "name" => "Key Books / Guides",
        ]);
        MaterialType::create([
            "name" => "Notes",
        ]);
        MaterialType::create([
            "name" => "Slides",
        ]);
        MaterialType::create([
            "name" => "Past Papers",
        ]);
    }
}
