<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    //
    use Notifiable, HasFactory;

    protected $table = 'admins';
    protected $fillable = [
        'name', 'email', 'password', 'image', 'phone'
    ];
    protected $hidden = [
        'password',
    ];

    protected $guard  = "admin";
}
