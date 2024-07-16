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
        $table->foreignId('barang_id')->nullable()->constrained('barang')->onDelete('cascade');
            $table->string('name');
            $table->string('no_inventaris')->nullable();
            $table->string('slug');
            $table->text('spek');
            $table->string('stock');
            $table->string('satuan');
            $table->string('barang_diambil')->nullable();
            $table->string('tujuan')->nullable();
            $table->enum('jenis_barang', ['Aset', 'Persediaan']);
            $table->foreignId('jenis_anggaran_id')->nullable()->constrained(table: 'jenis_anggaran');
            $table->string('qr_code')->nullable();
            $table->string('tahun')->nullable();
            $table->date('tgl_faktur')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('penerima')->nullable();
            $table->date('tgl_masuk')->nullable();
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
