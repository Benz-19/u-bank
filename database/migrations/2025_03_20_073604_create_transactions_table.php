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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Reference to the user
            $table->enum('type', ['deposit', 'withdrawal', 'transfer', 'payment']); // Type of transaction
            $table->decimal('amount', 15, 2); // Transaction amount
            $table->decimal('balance_after', 15, 2); // Balance after transaction
            $table->string('currency', 10)->default('USD'); // Currency type
            $table->integer('senderAcc_no');
            $table->integer('recipientAcc_no');
            $table->string('status')->default('pending'); // Status (pending, completed, failed)
            $table->foreignId('recipient_id')->nullable()->constrained('users')->onDelete('cascade'); // For transfers
            $table->string('reference')->unique(); // Unique transaction reference
            $table->text('description')->nullable(); // Optional description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
