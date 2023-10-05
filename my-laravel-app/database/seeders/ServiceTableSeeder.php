<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            ['service' => 'подкачка колес', 'price' => 50],
            ['service' => 'ремонт коретки', 'price' => 1200],
            ['service' => 'замена цепи', 'price' => 500],
            ['service' => 'исправление восьмерки', 'price'=> 2500]
        ]);
    }
}
