<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('smart_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['traffic', 'resource', 'delivery', 'system'])->default('system');
            $table->enum('severity', ['info', 'warning', 'critical'])->default('info');
            $table->string('module')->nullable(); // transport, logistics, resources
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('smart_notifications');
    }
};
