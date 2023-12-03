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
        Schema::create('barang_gudang', function (Blueprint $table) {
            $table->id();
            $table->uuid();
        $table->foreignId('barang_id')->nullable()->constrained('barang');
            $table->string('name');
            $table->string('slug');
            $table->string('spek');
            $table->string('satuan');
            $table->string('keterangan')->nullable();
            $table->string('lokasi')->nullable();
            $table->foreignId('anggaran_id')->nullable()->constrained('anggaran')->onDelete('set null');
            $table->string('qr_code')->nullable();
            $table->string('tahun')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_gudang');
    }
};
