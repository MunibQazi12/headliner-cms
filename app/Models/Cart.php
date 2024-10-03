<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'product_attr_id',
        'quantity',
        'price',
        'agency_id',
        'address',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function product_attribute()
    {
        return $this->belongsTo(ProductAttribut::class, 'product_attr_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function agency()
    {
        return $this->belongsTo(SeoSetting::class, 'agency_id');
    }
}
