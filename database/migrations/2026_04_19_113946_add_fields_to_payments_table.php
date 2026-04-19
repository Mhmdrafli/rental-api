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
    Schema::table('payments', function (Blueprint $table) {
        $table->foreignId('booking_id')->constrained();
        $table->enum('method', ['transfer', 'qris']);
        $table->bigInteger('amount');
        $table->string('proof_url')->nullable();
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    });
}

public function down(): void
{
    Schema::table('payments', function (Blueprint $table) {
        $table->dropColumn(['booking_id', 'method', 'amount', 'proof_url', 'status']);
    });
}
};
