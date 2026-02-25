<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('item_id')
                ->constrained('item_master')
                ->cascadeOnDelete();

            $table->integer('quantity');

            $table->enum('type', ['out', 'in'])->default('out');

            $table->enum('status', ['pending', 'completed'])->default('pending');

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

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