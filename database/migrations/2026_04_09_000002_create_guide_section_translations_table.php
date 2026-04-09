<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guide_section_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guide_section_id')->constrained('guide_sections')->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('title');
            $table->longText('content')->nullable();
            $table->timestamps();

            $table->unique(['guide_section_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guide_section_translations');
    }
};
