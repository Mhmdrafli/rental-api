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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->foreignId('car_id')->constrained();
        $table->dateTime('start_at');
        $table->dateTime('end_at');
        $table->dateTime('returned_at')->nullable();
        $table->integer('base_total');
        $table->integer('fine_amount')->default(0);
        $table->enum('status', ['awaiting_payment', 'active', 'returned', 'rejected'])->default('awaiting_payment');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
