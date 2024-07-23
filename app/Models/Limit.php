<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Limit extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'limit_anggaran';
    protected $guarded = ['id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(function (string $eventName) {
                switch ($eventName) {
                    case 'created':
                        $message = 'Menambahkan limit anggaran di '. $this->jurusan->name;
                        break;
                    case 'updated':
                        $message = 'Mengubah  limit anggaran di '. $this->jurusan->name;
                        break;
                    case 'deleted':
                        $message = 'Menghapus limit anggaran di '. $this->jurusan->name;
                        break;
                }
                return $message;
            })
            ->logOnlyDirty();
        // ->useLogName(Auth::user()->username);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class);
    }
}
