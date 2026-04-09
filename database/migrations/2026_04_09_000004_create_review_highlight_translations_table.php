<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_highlight_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_highlight_id')->constrained('review_highlights')->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('text');
            $table->timestamps();

            $table->unique(['review_highlight_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_highlight_translations');
    }
};
