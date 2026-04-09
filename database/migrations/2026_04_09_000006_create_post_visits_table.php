<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->date('visited_on');
            $table->unsignedInteger('views')->default(1);
            $table->unique(['post_id', 'visited_on']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_visits');
    }
};
