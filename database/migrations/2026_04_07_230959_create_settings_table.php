<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed defaults
        DB::table('settings')->insert([
            ['key' => 'site_name',            'value' => 'Corex-Dev',                          'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_description',     'value' => 'Tu portal de gaming y tecnología.',  'created_at' => now(), 'updated_at' => now()],
            ['key' => 'site_keywords',        'value' => 'gaming, tecnología, noticias',       'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maintenance_mode',     'value' => '0',                                  'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maintenance_message',  'value' => 'Estamos realizando mantenimiento. Volvemos pronto.', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maintenance_eta',      'value' => '',                                   'created_at' => now(), 'updated_at' => now()],
            ['key' => 'social_twitter',       'value' => '',                                   'created_at' => now(), 'updated_at' => now()],
            ['key' => 'social_discord',       'value' => '',                                   'created_at' => now(), 'updated_at' => now()],
            ['key' => 'social_youtube',       'value' => '',                                   'created_at' => now(), 'updated_at' => now()],
            ['key' => 'posts_per_page',       'value' => '12',                                 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'reviews_per_page',     'value' => '12',                                 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
