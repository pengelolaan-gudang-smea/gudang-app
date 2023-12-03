<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('limit_anggaran',function(Blueprint $table){
            $table->id();
            $table->double('limit');
            $table->foreignId('jurusan_id')->constrained('jurusan');
            $table->foreignId('anggaran_id')->constrained('anggaran')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limit_anggaran');
    }
};
