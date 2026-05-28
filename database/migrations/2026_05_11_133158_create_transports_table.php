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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->string('from_location');
            $table->string('to_location');
            $table->enum('traffic_level', ['low', 'medium', 'high'])->default('low');
            $table->enum('status', ['active', 'congested', 'closed'])->default('active');
            $table->string('transport_type')->default('road'); // road, rail, bus
            $table->integer('vehicle_count')->default(0);
            $table->time('peak_start')->nullable();
            $table->time('peak_end')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
