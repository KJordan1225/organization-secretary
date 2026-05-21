<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();

            $table->string('transaction_type');
            // income | expense

            $table->string('category');
            // dues, donation, utility bill, rent, supplies, etc.

            $table->decimal('amount', 10, 2);

            $table->date('transaction_date');

            $table->string('payment_method')->nullable();
            // cash, check, zelle, paypal, etc.

            $table->string('reference_number')->nullable();

            $table->string('payee')->nullable();
            // vendor/person paid

            $table->string('payer')->nullable();
            // who paid organization

            $table->string('status')->default('completed');

            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
