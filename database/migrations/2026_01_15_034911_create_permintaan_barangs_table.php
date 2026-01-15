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
    Schema::create('permintaan_barangs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('nama_barang');
        $table->string('merk_type');
        $table->integer('jumlah');
        $table->bigInteger('harga_satuan', 15, 2);
        $table->bigInteger('total', 15, 2);
        $table->string('supplier');
        $table->date('arrival_date');
        $table->text('keterangan')->nullable();
        $table->timestamps(); // created_at dipakai sebagai created date
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_barangs');
    }
};
