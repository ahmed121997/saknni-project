<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use \TomatoPHP\FilamentLanguageSwitcher\Traits\InteractsWithLanguages;
    use Notifiable, HasFactory;

    protected $table = 'admins';
    protected $fillable = [
        'name', 'email', 'password', 'image', 'phone','remember_token',
    ];
    protected $hidden = [
        'password',
    ];

    protected $guard  = "admin";
}
