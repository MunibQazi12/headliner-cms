<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function product_attribute()
    {
        return $this->belongsTo(ProductAttribut::class, 'product_attr_id');
    }
    
}
