<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cat;

class CatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cat::create([
            'name' => 'Tom',
            'breed' => 'Anggora',
            'gender' => 'Jantan',
            'age' => 3,
            'location' => 'Bandung',
            'is_available' => true,
            'is_vaccinated' => false,
            'description' => 'Jinak dan suka bermain',
            'image_url' => 'https://placekitten.com/400/400',
        ]);

        Cat::create([
            'name' => 'Luna',
            'breed' => 'Persia',
            'gender' => 'Betina',
            'age' => 1,
            'location' => 'Surabaya',
            'is_available' => true,
            'is_vaccinated' => true,
            'description' => 'Masih kecil dan lincah',
            'image_url' => 'https://placekitten.com/350/350',
        ]);
    }
}
