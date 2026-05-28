<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_number')->unique();
            $table->enum('type', ['truck', 'van', 'bus', 'motorcycle'])->default('truck');
            $table->string('driver_name');
            $table->string('driver_contact')->nullable();
            $table->enum('status', ['available', 'in_use', 'maintenance', 'retired'])->default('available');
            $table->decimal('fuel_level', 5, 2)->default(100); // percentage
            $table->integer('capacity_kg')->default(1000);
            $table->string('assigned_zone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
