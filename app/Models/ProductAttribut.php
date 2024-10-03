<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribut extends Model
{
    use HasFactory;
    protected $fillable=[
        'product_id',
        'size',
        'details',
        'price',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }
}
