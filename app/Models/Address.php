<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'place_id',
        'formatted_address',

    ];

    public function address()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
