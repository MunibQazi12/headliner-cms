<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Cms extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'text_content',
        'heading',
        'sub_title_one',
        'sub_title_two',
        'short_desc',
        'image',
        'button_text',
        'button_url',
        'meta_title',
        'meta_description',
        'open_graph_title',
        'open_graph_description',
        'open_graph_url',
        'open_graph_image',
        'x_card_title',
        'x_card_description'
    ];
    protected $appends = ['full_photo_url','featured_image_url'];
    
    public function getFullPhotoUrlAttribute()
    {
        return ("{$this->open_graph_image}") ? url()->to('/' . "{$this->open_graph_image}") : asset('admin_assets/no_image.jpg');
    }
    public function getFeaturedImageUrlAttribute()
    {
        return ("{$this->featured_image}") ? url()->to('/' . "{$this->featured_image}") : asset('admin_assets/no_image.jpg');
    }
}
