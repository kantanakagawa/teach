<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ThreadController::class, 'index'])
    ->name('root');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('threads', ThreadController::class)
->only([ 'store', 'edit', 'destroy','create', 'update'])
->middleware('auth');

Route::resource('threads', ThreadController::class)
->only(['show', 'index']);

require __DIR__.'/auth.php';
