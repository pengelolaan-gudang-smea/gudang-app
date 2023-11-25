<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangGudang extends Model
{
    use HasFactory;
    protected $table = 'barang_gudang';
    protected $guarded = ['id'];

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    protected $with = ['barang'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
