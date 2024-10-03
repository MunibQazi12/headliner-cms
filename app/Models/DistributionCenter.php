<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionCenter extends Model
{
    use HasFactory;
    protected $fillable = [
        'center_name',
        'address_line_1',
        'zip_code',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'status'
    ];
}
