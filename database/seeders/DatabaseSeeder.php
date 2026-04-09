<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Giveaway;
use App\Models\Post;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'name'              => 'Admin',
            'email'             => 'admin@corexdev.com',
            'password'          => Hash::make('password'),
            'is_admin'          => true,
            'email_verified_at' => now(),
        ]);

        // Categories
        $cats = [
            ['name' => 'Acción',       'color' => '#ff6b00', 'icon' => '🔥'],
            ['name' => 'RPG',          'color' => '#8b5cf6', 'icon' => '⚔️'],
            ['name' => 'FPS',          'color' => '#00d4ff', 'icon' => '🎯'],
            ['name' => 'Aventura',     'color' => '#22c55e', 'icon' => '🗺️'],
            ['name' => 'Deportes',     'color' => '#facc15', 'icon' => '⚽'],
            ['name' => 'Indie',        'color' => '#ec4899', 'icon' => '🎮'],
            ['name' => 'Multijugador', 'color' => '#f97316', 'icon' => '👥'],
        ];
        $categories = [];
        foreach ($cats as $c) {
            $categories[] = Category::create(array_merge($c, ['slug' => Str::slug($c['name']), 'description' => 'Categoría de videojuegos: ' . $c['name']]));
        }

        // Tags
        $tagNames = ['PC', 'PS5', 'Xbox', 'Nintendo Switch', 'Gratis', 'Early Access', 'Multijugador', 'AAA'];
        $tags = [];
        foreach ($tagNames as $t) {
            $tags[] = Tag::create(['name' => $t, 'slug' => Str::slug($t)]);
        }

        // Posts
        $posts = [
            ['title' => 'Las mejores novedades gaming de 2026', 'type' => 'news', 'is_slider' => true,  'is_featured' => true],
            ['title' => 'Todo lo que debes saber sobre el nuevo RPG del año', 'type' => 'news', 'is_slider' => true,  'is_featured' => false],
            ['title' => 'El FPS que está rompiendo récords en Steam', 'type' => 'news', 'is_slider' => true,  'is_featured' => false],
            ['title' => 'Análisis: ¿Vale la pena este juego de aventuras?', 'type' => 'news', 'is_slider' => false, 'is_featured' => true],
            ['title' => 'Los 10 juegos indie más esperados de este año',     'type' => 'news', 'is_slider' => false, 'is_featured' => false],
            ['title' => 'Actualización masiva llega al shooter más popular', 'type' => 'news', 'is_slider' => false, 'is_featured' => false],
            ['title' => 'Guía completa: Cómo superar el nivel más difícil',  'type' => 'guide', 'is_slider' => false, 'is_featured' => false],
            ['title' => 'Guía de builds para el RPG del momento',            'type' => 'guide', 'is_slider' => false, 'is_featured' => false],
        ];
        foreach ($posts as $i => $p) {
            $cat = $categories[$i % count($categories)];
            $post = Post::create([
                'user_id'      => $admin->id,
                'category_id'  => $cat->id,
                'title'        => $p['title'],
                'slug'         => Str::slug($p['title']),
                'excerpt'      => 'Resumen del artículo: ' . $p['title'],
                'content'      => '<p>Contenido de ejemplo para el post. ' . $p['title'] . '. Aquí iría el contenido completo del artículo con toda la información relevante para los lectores.</p>',
                'type'         => $p['type'],
                'is_featured'  => $p['is_featured'],
                'is_slider'    => $p['is_slider'],
                'status'       => 'published',
                'views'        => rand(100, 5000),
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
            $post->tags()->attach(array_slice(array_column($tags, 'id'), 0, 2));
        }

        // Reviews
        $reviewData = [
            ['title' => 'Review: El RPG del año no decepciona', 'game' => 'Dragon Quest XII', 'score' => 9.2, 'platform' => 'PC / PS5'],
            ['title' => 'Review: Shooter táctico con alma propia',  'game' => 'Tactical Storm',  'score' => 8.5, 'platform' => 'PC'],
            ['title' => 'Review: El juego de aventuras más bonito',  'game' => 'ArtQuest',         'score' => 7.8, 'platform' => 'Nintendo Switch'],
            ['title' => 'Review: El FPS loco que nadie esperaba',    'game' => 'Bullet Rush',      'score' => 8.0, 'platform' => 'PS5 / Xbox'],
        ];
        foreach ($reviewData as $i => $r) {
            Review::create([
                'user_id'      => $admin->id,
                'category_id'  => $categories[$i % count($categories)]->id,
                'title'        => $r['title'],
                'slug'         => Str::slug($r['title']),
                'excerpt'      => 'Análisis completo de ' . $r['game'],
                'content'      => '<p>Análisis detallado del juego ' . $r['game'] . '. Aquí se detalla la jugabilidad, gráficos, sonido y duración.</p>',
                'game'         => $r['game'],
                'score'        => $r['score'],
                'platform'     => $r['platform'],
                'developer'    => 'Estudio Ejemplo',
                'publisher'    => 'Publisher Ejemplo',
                'is_featured'  => $i === 0,
                'status'       => 'published',
                'views'        => rand(200, 3000),
                'published_at' => now()->subDays(rand(1, 15)),
            ]);
        }

        // Events
        $eventsData = [
            ['name' => 'Lanzamiento Dragon Quest XII',  'game' => 'Dragon Quest XII',  'type' => 'launch',    'days' => 30],
            ['name' => 'Expansión Bullet Rush: Chaos',  'game' => 'Bullet Rush',        'type' => 'expansion', 'days' => 45],
            ['name' => 'Demo Gratis: ArtQuest',          'game' => 'ArtQuest',           'type' => 'demo',      'days' => 10],
            ['name' => 'Steam Summer Sale 2026',          'game' => 'Múltiples juegos',  'type' => 'sale',      'days' => 20],
            ['name' => 'Update 3.0 Tactical Storm',      'game' => 'Tactical Storm',     'type' => 'update',    'days' => 7],
            ['name' => 'Gaming Fest 2026',                'game' => 'Varios',             'type' => 'event',     'days' => 60],
        ];
        foreach ($eventsData as $e) {
            Event::create([
                'name'       => $e['name'],
                'slug'       => Str::slug($e['name']),
                'description'=> 'Descripción del evento: ' . $e['name'],
                'game'       => $e['game'],
                'platform'   => 'PC / Consolas',
                'type'       => $e['type'],
                'event_date' => now()->addDays($e['days']),
                'is_featured'=> false,
            ]);
        }

        // Giveaways
        Giveaway::create([
            'user_id'          => $admin->id,
            'title'            => 'Sorteo: Copia de Dragon Quest XII',
            'slug'             => 'sorteo-dragon-quest-xii',
            'description'      => 'Participa para ganar una copia digital de Dragon Quest XII para PC.',
            'prize'            => 'Dragon Quest XII (PC) — €60',
            'start_date'       => now()->subDay(),
            'end_date'         => now()->addDays(14),
            'participation_url'=> '#',
            'status'           => 'active',
        ]);
        Giveaway::create([
            'user_id'    => $admin->id,
            'title'      => 'Próximo sorteo: Headset Gaming Pro',
            'slug'       => 'sorteo-headset-gaming-pro',
            'description'=> 'Próximamente sortearemos un headset gaming profesional.',
            'prize'      => 'Headset Gaming Pro — €150',
            'start_date' => now()->addDays(7),
            'end_date'   => now()->addDays(21),
            'status'     => 'upcoming',
        ]);
    }
}

