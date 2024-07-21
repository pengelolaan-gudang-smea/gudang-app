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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($barang) {
            $barang->no_inventaris = 'BRG-' . date('Ym') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
        });
    }



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
    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class);
    }

}


