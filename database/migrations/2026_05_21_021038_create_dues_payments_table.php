<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dues_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();

            $table->year('dues_year');
            $table->decimal('amount_due', 10, 2)->default(0);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->date('paid_at')->nullable();

            $table->string('payment_method')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('status')->default('unpaid');

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['member_id', 'dues_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dues_payments');
    }
};
