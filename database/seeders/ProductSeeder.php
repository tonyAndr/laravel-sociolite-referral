<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'service' => 'hamster',
                'description' => 'Hamster Kombat',
                'ppr' => 1
            ], 
            [
                'service' => 'dogs',
                'description' => 'DOGS',
                'ppr' => 2
            ], 
            [
                'service' => 'pixeltap',
                'description' => 'PixelTap',
                'ppr' => 3
            ], 
            [
                'service' => 'x_empire',
                'description' => 'X Empire',
                'ppr' => 3
            ], 
        ];

        \App\Models\Product::factory()->createMany($data);      
        
    }
}
