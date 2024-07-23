<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Saldo extends Model
{
    use HasFactory;
    protected $table = 'saldos';
    protected $guarded = ['id'];
    public function anggaran(){
        return $this->belongsTo(Anggaran::class);
    }
}
