<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('from_location');
            $table->string('to_location');
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->integer('estimated_minutes')->nullable();
            $table->enum('type', ['city', 'highway', 'ring_road', 'expressway'])->default('city');
            $table->enum('status', ['open', 'congested', 'closed', 'under_construction'])->default('open');
            $table->integer('avg_speed_kmh')->default(50);
            $table->text('waypoints')->nullable(); // JSON-like string of stops
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
