<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    use HasFactory;

    protected $table = 'limit_anggaran';
    protected $guarded = ['id'];
    
    public function jurusan(){
        return $this->belongsTo(Jurusan::class);
    }

    public function anggaran(){
        return $this->belongsTo(Anggaran::class);
    }
}
