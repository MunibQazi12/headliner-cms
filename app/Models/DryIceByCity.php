<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DryIceByCity extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'meta_title',
        'meta_description',
        'h1_tag',
        'city_lowercase',
        'state_short_abbr',
        'city',
        'state_code',
        'state',
        'zip_codes',
        'type',
        'latitude',
        'longitude',
        'faq_q_1',
        'faq_a_1',
        'faq_q_2',
        'faq_a_2',
        'faq_q_3',
        'faq_a_3',
        'faq_q_4',
        'faq_a_4',
        'faq_q_5',
        'faq_a_5',
        'faq_q_6',
        'faq_a_6',
        'faq_q_7',
        'faq_a_7',
        'status'
    ];
    protected $casts = [
        'status' => 'string',
    ];
}
