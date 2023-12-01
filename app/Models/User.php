<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword, HasRoles, HasPermissions, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'jurusan_id',
    ];

   public function getActivitylogOptions() :LogOptions
   {
    return LogOptions::defaults()
    ->logOnly(['name','username','email','jurusan_id'])
    ->setDescriptionForEvent(fn(string $eventName)=>"{$eventName} User")
    ->dontLogIfAttributesChangedOnly(['password'])
    ->logOnlyDirty();
    // ->useLogName(Auth::user()->username);
   }
    

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
        'password' => 'hashed',
    ];



    public function getRouteKeyName()
    {
        return 'username';
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public function rekapLogin(){
        return $this->hasMany(RekapLogin::class);
    }
}
