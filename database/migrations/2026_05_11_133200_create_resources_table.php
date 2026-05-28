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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['water', 'electricity', 'waste']);
            $table->string('sector'); // Sector 1, Sector 2 etc.
            $table->string('location');
            $table->decimal('current_usage', 10, 2)->default(0);
            $table->string('unit'); // kL, MW, Tons
            $table->decimal('alert_threshold', 10, 2)->nullable();
            $table->enum('status', ['normal', 'warning', 'critical'])->default('normal');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
