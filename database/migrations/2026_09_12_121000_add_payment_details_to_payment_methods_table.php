<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('account_number', 100)->nullable()->after('description');
            $table->string('account_name', 100)->nullable()->after('account_number');
            $table->text('details')->nullable()->after('account_name');
        });
    }

    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn(['description', 'account_number', 'account_name', 'details']);
        });
    }
};
