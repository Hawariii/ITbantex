<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('item_masters', function (Blueprint $table) {
            $table->id();

            $table->string('asset_no')->nullable()->index();
            $table->string('nama_barang')->index();
            $table->string('type')->nullable();
            $table->string('merk')->nullable();
            $table->text('spesifikasi')->nullable();

            $table->integer('stock')->default(0);
            $table->integer('stock_max')->nullable();
            $table->integer('stock_min')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_masters');
    }
};