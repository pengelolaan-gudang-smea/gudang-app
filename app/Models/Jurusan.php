<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Jurusan extends Model
{
    use HasFactory, HasSlug;
    protected $table = 'jurusan';
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function barang(){
     return $this->hasMany(Barang::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }

    public function limit(){
        return $this->hasMany(Limit::class);
    }
}
