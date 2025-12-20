<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_trust', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->enum('trust_level', ['new', 'contributor', 'trusted', 'ambassador'])->default('new');
            $table->integer('score')->default(0);
            $table->timestamp('last_promoted_at')->nullable();
            $table->timestamps();

            $table->index('trust_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_trust');
    }
};
