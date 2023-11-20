<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangGudang extends Model
{
    use HasFactory;
    protected $table = 'barang_gudang';
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
