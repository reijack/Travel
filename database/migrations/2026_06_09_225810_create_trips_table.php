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
    Schema::create('trips', function (Blueprint $table) {
        $table->id();
        $table->string('trip_name');
        $table->string('destination');
        $table->date('start_date');
        $table->date('end_date');
        $table->integer('people')->default(1);
        $table->bigInteger('budget')->default(0);
        $table->string('status')->default('planned');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
