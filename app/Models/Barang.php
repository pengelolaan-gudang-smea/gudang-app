<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $guarded = ['id'];

    // public function getActivitylogOptions() :LogOptions
    // {
    //  return LogOptions::defaults()
    //  ->setDescriptionForEvent(fn(string $eventName)=>"{$eventName} Barang")
    //  ->logOnlyDirty();
    //  // ->useLogName(Auth::user()->username);
    // }

   

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function jurusan(){
        return $this->belongsTo(Jurusan::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function barangUser($user){
       return $this->where('user_id',$user);
    }
    public function gudang(){
        return $this->hasMany(BarangGudang::class);
    }
}


