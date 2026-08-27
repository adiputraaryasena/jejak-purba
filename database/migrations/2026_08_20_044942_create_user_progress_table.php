<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('era_id')->constrained()->onDelete('cascade');
            $table->boolean('is_unlocked')->default(false); // Status Terbuka/Terkunci
            $table->boolean('is_completed')->default(false); // Status Selesai Mini-Game & Kuis
            $table->integer('quiz_score')->default(0);       // Skor Kuis Per Era
            $table->string('badge_unlocked')->nullable();    // Nama Badge / Achievement
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};