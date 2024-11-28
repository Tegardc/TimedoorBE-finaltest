<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = Size::factory()->count(5)->create();
        foreach ($sizes as $size) {
            Size::factory()->count(5)->create(['size_id' => $size->id,]);
        }
        //
    }
}
