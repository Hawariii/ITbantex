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
        Schema::create('permintaan_export_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('export_id')
                ->constrained('permintaan_exports')
                ->cascadeOnDelete();

            $table->string('nama_barang');
            $table->string('merk_type');
            $table->integer('jumlah');

            // rupiah: simpan angka bulat (tanpa koma)
            $table->unsignedBigInteger('harga_satuan');
            $table->unsignedBigInteger('total');

            $table->string('supplier');
            $table->date('arrival_date');
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_export_items');
    }
};
