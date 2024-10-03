<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'meta_title',
        'meta_description',
        'h1_tag',
        'h2_tag',
        'p_tag',
        'city',
        'state',
        'state_code',
        'zip_codes',
        'type',
        'latitude',
        'longitude',
    ];

    protected $appends = [
        'open_graph_image_url'
    ];

    public function agency()
    {
        return $this->hasMany(Cart::class);
    }

    public function getOpenGraphImageUrlAttribute()
    {
        return asset('admin_assets/no_image.jpg');
    }
}
