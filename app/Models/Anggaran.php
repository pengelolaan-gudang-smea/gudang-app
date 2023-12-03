<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Anggaran extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'anggaran';
    protected $guarded = ['id'];

    public function getActivitylogOptions() :LogOptions
    {
     return LogOptions::defaults()
     ->setDescriptionForEvent(function(string $eventName){
        switch ($eventName) {
            case 'created':
                $message = 'Menambahkan anggaran';
                break;
            case 'edited':
                $message = 'Mengubah data anggaran';
                break;
            case 'deleted':
                $message = 'Menghapus anggaran';
                break;
        }
        return $message;
     })
     ->logOnlyDirty();
     // ->useLogName(Auth::user()->username);
    }

    public function limit()
    {
        return $this->hasMany(Limit::class);
    }
}
