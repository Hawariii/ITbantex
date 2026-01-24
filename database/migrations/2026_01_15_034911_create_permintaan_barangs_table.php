<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_barangs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // ✅ doc_no wajib ada sejak create
            $table->string('doc_no');

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

            // ✅ biar cepat grouping per user + doc_no
            $table->index(['user_id', 'doc_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_barangs');
    }
};
