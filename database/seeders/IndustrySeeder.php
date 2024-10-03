<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'title' => 'Agriculture',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Airlines',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Education',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Food & Beverage',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Food Delivery',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Food Processing',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Healthcare',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Industrial Manufacturing',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Meat Processing',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Oil & Gas',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Pharmaceuticals',
                'short_description' => 'lorem ipsum'
            ],
            [
                'title' => 'Retail',
                'short_description' => 'lorem ipsum'
            ],

        ];
        foreach ($datas as $data) {
            Industry::create($data);
        }
    }
}
