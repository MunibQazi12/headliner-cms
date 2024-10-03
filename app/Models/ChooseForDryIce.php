<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChooseForDryIce extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'thumbnail', 'status'];

    protected $appends = ['full_photo_url'];
    protected $casts = [
        'status' => 'string',
    ];

    public function getFullPhotoUrlAttribute()
    {
        return ("{$this->thumbnail}") ? url()->to('/' . "{$this->thumbnail}") : asset('admin_assets/no_image.jpg');
    }
}
