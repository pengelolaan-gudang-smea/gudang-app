<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Waka extends Model
{
    use HasFactory, CanResetPassword, HasRoles;
    protected $guarded = ['id'];
    protected $table = 'admin_waka';
    protected $guard = 'admin_waka';
    protected $hidden = [
        'password',
        'remember_token'
    ];
    public function getRouteKeyName()
    {
        return 'username';
    }
}
