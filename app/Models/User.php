<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'company',
        'password',
        'customer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'string',
    ];

    protected $appends = [
        'full_name', 'role_name', 'profile_photo_url'
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getRoleNameAttribute()
    {
        if ($this->roles()->exists())
            return $this->roles()->first()->name;
        else
            return 0;
    }
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getDobAttribute($val)
    {
        return $val ? date('m-d-Y', strtotime($val)) : null;
    }

    public function getProfilePhotoUrlAttribute()
    {
        return ("{$this->profile_photo_path}") ? url()->to('/' . "{$this->profile_photo_path}") : asset('admin_assets/demo.png');
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function address()
    {
        return $this->hasMany(Address::class);
    }
}
