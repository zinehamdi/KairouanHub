<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('provider_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // EN: linked user / AR: المستخدم المرتبط
            $table->string('display_name'); // EN: public display name / AR: اسم العرض العام
            $table->text('bio')->nullable(); // EN: biography / AR: نبذة تعريفية
            $table->string('city'); // EN: primary city / AR: المدينة الأساسية
            $table->json('cities_json')->nullable(); // EN: additional covered cities / AR: مدن إضافية
            $table->json('skills_json')->nullable(); // EN: skill tags / AR: مهارات
            $table->json('photos_json')->nullable(); // EN: gallery image paths / AR: صور المعرض
            $table->enum('badge_level', ['none', 'bronze', 'silver', 'gold'])->default('none'); // EN: badge level / AR: مستوى الشارة
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // EN: moderation status / AR: حالة المراجعة
            $table->decimal('avg_rating', 3, 2)->nullable(); // EN: average rating 0-5 / AR: التقييم المتوسط
            $table->unsignedInteger('completed_jobs')->default(0); // EN: jobs done / AR: طلبات مكتملة
            $table->json('social_json')->nullable(); // EN: social links / AR: روابط اجتماعية
            $table->string('website')->nullable(); // EN: website URL / AR: موقع إلكتروني
            $table->timestamps();

            $table->unique('user_id');
            $table->index('city');
            $table->index('status');
            $table->index('badge_level');
        });

        // Optional check constraint for avg_rating range (supported on MySQL 8+, Postgres, etc.)
        // Optional check constraint removed for compatibility
        // try {
        //     Schema::table('provider_profiles', function (Blueprint $table) {
        //         $table->rawIndex('(avg_rating >= 0.00 AND avg_rating <= 5.00)', 'provider_profiles_avg_rating_range');
        //     });
        // } catch (Throwable $e) {
        //     // Silently ignore if DB driver doesn't support raw index / constraint syntax
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_profiles');
    }
};
