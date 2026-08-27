<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;

// Auth Routes (Frame 1)
Route::get('/', [GameController::class, 'index'])->name('login');
Route::post('/guest-login', [AuthController::class, 'playAsGuest'])->name('guest.login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login-user', [AuthController::class, 'login'])->name('user.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Game Routes (Harus Login / Guest dulu)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [GameController::class, 'home'])->name('game.home');
    Route::get('/timeline', [GameController::class, 'timeline'])->name('game.timeline');
    Route::get('/era/{slug}', [GameController::class, 'eraDetail'])->name('game.era');
    Route::get('/quiz-list', [GameController::class, 'quizList'])->name('game.quiz.list');
    Route::get('/quiz/{slug}', [GameController::class, 'quiz'])->name('game.quiz');
    Route::post('/quiz/{slug}/submit', [GameController::class, 'submitQuiz'])->name('game.quiz.submit');
    Route::post('/game/save-fossil', [GameController::class, 'saveFossil'])->name('game.saveFossil');
    Route::get('/pencapaian', [GameController::class, 'pencapaian'])->name('game.pencapaian');
    
    // Route Sync Akun Guest ke Permanen
    Route::post('/guest/sync', [GameController::class, 'syncAccount'])->name('guest.sync');
});