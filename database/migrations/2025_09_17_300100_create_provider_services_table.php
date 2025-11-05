<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provider_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('provider_profiles')->cascadeOnDelete(); // EN: provider profile / AR: مزود الخدمة
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete(); // EN: service / AR: الخدمة
            $table->unsignedInteger('price_min')->nullable(); // EN: minimum price / AR: السعر الأدنى
            $table->unsignedInteger('price_max')->nullable(); // EN: maximum price / AR: السعر الأعلى
            $table->timestamps();

            $table->unique(['provider_id','service_id']);
        });

        // Optional check constraint for price range
        try {
            Schema::table('provider_services', function (Blueprint $table) {
                $table->rawIndex('((price_min IS NULL OR price_max IS NULL) OR price_min <= price_max)', 'provider_services_price_range_check');
            });
        } catch (Throwable $e) {
            // Ignore if unsupported
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_services');
    }
};
