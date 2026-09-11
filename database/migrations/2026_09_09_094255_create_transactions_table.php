<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->string('transaction_code', 50)->unique();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('customers');

            $table->foreignId('user_id')
                ->constrained('users');

            $table->dateTime('transaction_date');

            $table->decimal('total_amount', 15, 2);

            $table->string('payment_method', 30);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};