<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FastApiController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\MessageController;

// Home route
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register', function () {
    return view('register');
})->name('register.form');
Route::get('/login', function () {
    return view('login');
})->name('login.form');
// Authentication routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// File upload and analysis routes
Route::get('/upload', [FastApiController::class, 'showUploadForm'])->name('upload.form');
Route::post('/analyze', [FastApiController::class, 'analyzeImage'])->name('analyze.image');
Route::get('/results', [FastApiController::class, 'results'])->name('results.form');
Route::get('/download-results', [FastApiController::class, 'downloadResults'])->name('download.results');

// Chat route for doctor
Route::get('/chat/doctor', [ChatController::class, 'index'])->name('chat.doctor');
Route::resource('doctors', DoctorController::class);
Route::get('/specializations', [SpecializationController::class, 'index'])->name('specializations.index');
Route::get('/specializations/{id}/doctors', [SpecializationController::class, 'showDoctors'])->name('specializations.showDoctors');
Route::get('/ask-doctor/{specialization}', [DoctorController::class, 'showDoctorsBySpecialization'])->name('chat.doctor');
Route::post('/send-message/{doctor_id}', [MessageController::class, 'sendMessage'])->name('send.message');

Route::get('/doctors/specialization/{specialization}', [DoctorController::class, 'listBySpecialization'])->name('doctors.bySpecialization');
