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
                'description' => 'hamster game',
                'ppr' => 1
            ], 
            [
                'service' => 'cryptodog',
                'description' => 'cryptodog game',
                'ppr' => 2
            ], 
            [
                'service' => 'cryptocat',
                'description' => 'cryptocat game',
                'ppr' => 3
            ], 
        ];

        \App\Models\Product::factory()->createMany($data);      
        
    }
}
