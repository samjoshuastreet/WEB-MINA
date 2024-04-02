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
        Schema::create('procedure_waypoints', function (Blueprint $table) {
            $table->id();
            $table->string('step_no');
            $table->text('instructions');
            $table->foreignId('procedure_id')->constrained('procedures');
            $table->foreignId('building_id')->constrained('buildings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedure_waypoints');
    }
};
