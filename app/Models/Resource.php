<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'thumbnail',
        'resource_desc',
        'slug',
        'meta_title',
        'meta_description',
        'open_graph_title',
        'open_graph_description',
        'open_graph_url',
        'open_graph_image',
        'schema',
        'x_card_title',
        'x_card_description',
        'canonical_url',
        'featured_image',
        'status'
    ];
    protected $appends = ['open_graph_image_url', 'featured_image_url'];
    protected $casts = [
        'status' => 'string',
    ];
    public function getThumbnailAttribute($thumbnail)
    {
        return ("{$thumbnail}") ? url()->to('/' . "{$thumbnail}") : asset('admin_assets/demo.png');
    }


    public function getOpenGraphImageUrlAttribute()
    {
        return ("{$this->open_graph_image}") ? url()->to('/' . "{$this->open_graph_image}") : asset('admin_assets/no_image.jpg');
    }

    public function getFeaturedImageUrlAttribute()
    {
        return ("{$this->featured_image}") ? url()->to('/' . "{$this->featured_image}") : asset('admin_assets/no_image.jpg');
    }
}
