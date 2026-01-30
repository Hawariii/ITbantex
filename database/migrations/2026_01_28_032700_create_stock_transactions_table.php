<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();

            // RELATION
            $table->foreignId('item_master_id')
                ->constrained('item_masters')
                ->cascadeOnDelete();

            // DATA TRANSAKSI
            $table->integer('qty');

            $table->enum('type', ['OUT', 'IN']);
            $table->enum('source', ['CLIENT_EXPORT', 'REPLACEMENT']);
            $table->enum('status', ['PENDING', 'CONFIRMED'])
                ->default('PENDING');

            // REFERENSI / AUDIT
            $table->string('ref_no')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('confirmed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('confirmed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};