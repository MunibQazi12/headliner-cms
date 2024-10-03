<?php

namespace Database\Seeders;

use App\Models\ChooseForDryIce;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChooseForSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ['title' => 'Compliant'],
            ['title' => 'Eco-friendly'],
            ['title' => 'Reliable'],
            ['title' => 'Safe'],
            ['title' => 'Transparent'],
            ['title' => 'Trustworthy'],
        ];
        foreach ($datas as $key => $value) {
            ChooseForDryIce::create($value);
        }
    }
}
