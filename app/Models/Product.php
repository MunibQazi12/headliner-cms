<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'available_stock',
        'status',
        'slug',
        'meta_title',
        'meta_description',
        'open_graph_title',
        'open_graph_description',
        'open_graph_url',
        'open_graph_image',
        'schema', 'x_card_title',
        'x_card_description',
        'canonical_url',
        'featured_image'
    ];

    protected $appends = [
        'product_image_url',
        'open_graph_image_url',
        'featured_image_url'
    ];
    protected $casts = [
        'status' => 'string',
    ];

    public function getProductImageUrlAttribute()
    {
        return ("{$this->image}") ? url()->to('/' . "{$this->image}") : asset('admin_assets/no_image.jpg');
    }

    public function getOpenGraphImageUrlAttribute()
    {
        return ("{$this->open_graph_image}") ? url()->to('/' . "{$this->open_graph_image}") : asset('admin_assets/no_image.jpg');
    }

    public function getFeaturedImageUrlAttribute()
    {
        return ("{$this->featured_image}") ? url()->to('/' . "{$this->featured_image}") : asset('admin_assets/no_image.jpg');
    }

    public function product_attr()
    {
        return $this->hasMany(ProductAttribut::class);
    }
    public function product_shipping()
    {
        return $this->hasMany(ProductShippings::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function faqs()
    {
        return $this->hasMany(ProductFaq::class);
    }
}
