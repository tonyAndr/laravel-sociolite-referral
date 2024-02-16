<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdPartnersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GiveawayController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\WithdrawalController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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

Route::get('/giveaway', [GiveawayController::class, 'index'])->name('giveaway');

Route::middleware('auth')->group(function () {
    Route::get('/withdrawal', [WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::post('/withdrawal/create', [WithdrawalController::class, 'create'])->name('withdrawal.create');
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

Route::controller(AdPartnersController::class)->group(function () {
    // Route::get('/partner/redirect/{provider}', 'redirect')->name('partner.redirect');
    Route::get('/partner/callback/{provider}', 'callback')->name('partner.callback');
});

Route::middleware('auth')->controller(OffersController::class)->group(function () {
    // Route::get('/partner/redirect/{provider}', 'redirect')->name('partner.redirect');
    Route::get('/offerwall/cpalead', 'cpalead')->name('offerwall.cpalead');
    Route::get('/offerwall/mylead', 'mylead')->name('offerwall.mylead');
    Route::get('/offerwall/ayetstudios', 'ayetstudios')->name('offerwall.ayetstudios');
});
