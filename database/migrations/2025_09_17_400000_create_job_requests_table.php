<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** EN: Create job_requests table. AR: إنشاء جدول طلبات الخدمات */
    public function up(): void
    {
        Schema::create('job_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->text('details');
            $table->json('photos_json')->nullable();
            $table->string('city');
            $table->enum('status', ['open','matched','completed','cancelled'])->default('open')->index();
            $table->timestamps();

            $table->index('client_id');
            $table->index('category_id');
            $table->index('service_id');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_requests');
    }
};
