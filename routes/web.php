<?php

use App\Http\Controllers\OAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
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

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::controller(OAuthController::class)->group(function () {
    Route::get('/auth/redirect/{provider}', 'redirect')->name('oauth.redirect');
    Route::get('/auth/callback/{provider}', 'callback')->name('oauth.callback');
});

Route::group(['prefix' => 'referrals'], function () {
    Route::get('/', [ReferralController::class, 'index'])->name('referrals');
    Route::get('/create', [ReferralController::class, 'create'])->name('referrals.create');
    Route::post('/', [ReferralController::class, 'store']);
});

