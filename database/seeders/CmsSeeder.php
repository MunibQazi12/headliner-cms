<?php

namespace Database\Seeders;

use App\Models\Cms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-service',
                'text_content' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets contain"
            ], 
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'text_content' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets contain"
            ], 
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'text_content' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets contain"
            ],
            [
                'title' => 'Why Us',
                'slug' => 'why-us',
                'text_content' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets contain"
            ],
            [
                'title' => 'Home Page',
                'slug' => 'home-page',
                'heading' => 'We Support Busy Businesses with Premium Dry Ice Products',
                'short_desc' => 'Get affordable bulk dry ice with transparent pricing and dependable 24/7 customer service - always.',
                'sub_title_one' => 'Learn About Emory’s Dry Ice Products & Delivery Services',
                'sub_title_two' => 'We are deeply committed to providing exceptional dry ice products, comprehensive coverage, and customer service'
            ],
            [
                'title' => 'Faq',
                'slug' => 'faq',
                
            ],
            [
                'title' => 'SEO',
                'slug' => 'seo',
                'heading' => 'Get Premium Dry Ice in Philadelphia, PA Delivered Right to You.',
                'short_desc' => 'Need high quality dry ice? EMORY manufactures and delivers affordable bulk dry ice with transparent pricing and dependable 24/7 customer service.',
                'sub_title_one' => 'Learn About Emory’s Dry Ice Products & Delivery Services',
                'sub_title_two' => 'We are deeply committed to providing exceptional dry ice products, comprehensive coverage, and customer service.'
            ],
            [
                'title' => 'Need Custom Cut Dry Ice',
                'slug' => 'need-custom-dry-ice',
                'text_content' => NULL,
                'heading' => 'Need Custom Cut Dry Ice?',
                'short_desc' => 'Emory can help you. We can manufacture and deliver any type of custom cut dry ice products based on your requirements.',
                'sub_title_one' => 'Get a Free Quote Today',
                'button_text' => 'Contact Us',
                'button_url' => 'https://emory.dedicateddevelopers.us/'
            ],
        ];
        foreach ($datas as $data) {
            Cms::create($data);
        }
    }
}
