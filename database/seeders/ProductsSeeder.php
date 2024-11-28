<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $data = [
            [
                'name' => 'Full Body Japanese Style',
                'price' => 100,
                'quantity' => 2,
                'description' => 'Bla bla bla bla',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Full Hand OldSchool Style',
                'price' => 80,
                'quantity' => 3,
                'description' => 'Bla bla bla bla',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Full Body Balinese Style',
                'price' => 100,
                'quantity' => 3,
                'description' => 'Bla bla bla bla',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];
        foreach ($data as $product) {
            Products::insert($product);
        }
        //
    }
}
