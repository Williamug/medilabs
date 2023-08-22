<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/laravel/login', fn () => redirect(route('filament.auth.login')))->name('login');

Route::redirect('/', '/admin/login', 301)->name('login');
Route::redirect('/login', '/admin/login', 301)->name('login');
