<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eras', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // Nama Era (Arkaikum, Paleozoikum, dll)
            $table->string('slug')->unique();     // URL Identifier (arkaikum, paleozoikum)
            $table->text('story_text');           // Teks Cerita Edukasi
            $table->string('bgm_file');           // File Audio Musik Latar
            $table->integer('order_level');       // Urutan Level (1, 2, 3, 4)
            $table->integer('min_score_unlock');  // Syarat Skor Kuis Era Sebelumnya
            $table->string('fossil_name');        // Nama Fosil yang Ditemukan (misal: Fosil T-Rex)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eras');
    }
};