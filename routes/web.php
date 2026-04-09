<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GiveawayController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UcpController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ──────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Legal
Route::get('/terminos', fn() => view('legal.terms'))->name('legal.terms');
Route::get('/privacidad', fn() => view('legal.privacy'))->name('legal.privacy');

// Locale switcher
Route::post('/locale/{lang}', [LocaleController::class, 'switch'])->name('locale.switch');

// Noticias & Guías
Route::get('/noticias', [PostController::class, 'index'])->name('posts.index');
Route::get('/noticias/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/guias', [PostController::class, 'guides'])->name('guides.index');
Route::get('/guias/{slug}', [PostController::class, 'show'])->name('guides.show');

// Categoría
Route::get('/categoria/{slug}', [PostController::class, 'byCategory'])->name('categories.show');

// Reseñas
Route::get('/resenas', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/resenas/{slug}', [ReviewController::class, 'show'])->name('reviews.show');

// Calendario de Eventos
Route::get('/calendario', [EventController::class, 'index'])->name('events.index');
Route::get('/calendario/{slug}', [EventController::class, 'show'])->name('events.show');

// Sorteos
Route::get('/sorteos', [GiveawayController::class, 'index'])->name('giveaways.index');
Route::get('/sorteos/{slug}', [GiveawayController::class, 'show'])->name('giveaways.show');

// ─── Auth Routes ─────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// ─── UCP (User Control Panel) ────────────────────────────────────────────────
Route::prefix('mi-cuenta')->name('ucp.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/',         [UcpController::class, 'index'])->name('index');
    Route::get('/perfil',   [UcpController::class, 'profile'])->name('profile');
    Route::get('/seguridad',[UcpController::class, 'security'])->name('security');
});

// Keep legacy /profile redirecting to UCP
Route::get('/profile', fn() => redirect()->route('ucp.profile'))->name('profile.edit')->middleware('auth');

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('posts', Admin\PostController::class);
    Route::resource('reviews', Admin\ReviewController::class);
    Route::resource('events', Admin\EventController::class);
    Route::resource('giveaways', Admin\GiveawayController::class);
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('users', Admin\UserController::class);
    Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

    // Statistics
    Route::get('stats', [Admin\StatsController::class, 'index'])->name('stats.index');

    // Comment moderation
    Route::get('comments', [Admin\CommentController::class, 'index'])->name('comments.index');
    Route::patch('comments/{comment}/approve', [Admin\CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('comments/{comment}', [Admin\CommentController::class, 'destroy'])->name('comments.destroy');
});

require __DIR__.'/auth.php';
