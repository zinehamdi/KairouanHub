<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** EN: Create offers table. AR: إنشاء جدول العروض */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('job_requests')->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('provider_profiles')->cascadeOnDelete();
            $table->text('note')->nullable();
            $table->integer('eta_days')->nullable();
            $table->integer('price')->nullable();
            $table->enum('status', ['pending','accepted','rejected'])->default('pending')->index();
            $table->timestamps();

            $table->index('request_id');
            $table->index('provider_id');
            $table->unique(['request_id','provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
