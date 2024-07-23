<?php

namespace App\Models;

use Carbon\Carbon;
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
        static::creating(function ($barang) {
            $barang->no_inventaris = 'BRG-' . date('Ym') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
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
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
    // Scope untuk filter hari ini
    public function scopeHariIni($query)
    {
        return $query->whereDate('tgl_masuk', Carbon::today());
    }

    // Scope untuk filter minggu ini
    public function scopeMingguIni($query)
    {
        return $query->whereBetween('tgl_masuk', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    // Scope untuk filter bulan ini
    public function scopeBulanIni($query)
    {
        return $query->whereBetween('tgl_masuk', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
    }
}
