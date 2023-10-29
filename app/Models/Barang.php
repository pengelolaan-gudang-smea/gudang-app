<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $guarded = ['id'];

    public function scopeSearch($query, $search)
    {
        $query->when($search ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
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
}


