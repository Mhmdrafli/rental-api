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
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['car_id']);
        $table->foreign('car_id')
              ->references('id')
              ->on('cars')
              ->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['car_id']);
        $table->foreign('car_id')
              ->references('id')
              ->on('cars');
    });
}
};
