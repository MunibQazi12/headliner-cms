<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'desc', 'active', 'thumbnail'];

    protected $appends = [
        'category_image_url'
    ];
    protected $casts = [
        'active' => 'string',
    ];

    public function getCategoryImageUrlAttribute()
    {
        return ("{$this->thumbnail}") ? url()->to('/' . "{$this->thumbnail}") : asset('admin_assets/no_image.jpg');
    }
}
