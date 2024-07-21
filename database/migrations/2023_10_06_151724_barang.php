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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('no_inventaris');
            $table->text('spek');
            $table->double('harga');
            $table->integer('stock');
            $table->string('satuan');
            $table->string('sub_total')->nullable();
            $table->string('status')->default('Belum disetujui');
            $table->string('keterangan')->nullable();
            $table->date('expired')->nullable();
            $table->string('tujuan')->nullable();
            $table->enum('jenis_barang', ['Aset', 'Persediaan']);
            $table->foreignId('anggaran_id')->nullable()->constrained(table: 'anggaran');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jurusan_id')->constrained('jurusan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
