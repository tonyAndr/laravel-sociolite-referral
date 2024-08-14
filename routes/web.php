<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdPartnersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GiveawayController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\UserTaskController;
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
Route::controller(GiveawayController::class)->group(function () {

    Route::get('/giveaway', 'index')->name('giveaway');
    Route::get('/giveaway/quiz', 'quiz')->name('giveaway.quiz');
    Route::get('/giveaway/countdown', 'countdown')->middleware(['auth'])->name('giveaway.countdown');
});

Route::middleware('auth')->group(function () {
    Route::get('/withdrawal', [WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::get('/withdrawal/instruction', [WithdrawalController::class, 'instruction'])->name('withdrawal.instruction');
    Route::post('/withdrawal/create', [WithdrawalController::class, 'create'])->name('withdrawal.create');
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/tasks', [AdminController::class, 'tasks'])->name('admin.tasks');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/withdrawals', [AdminController::class, 'withdrawals'])->name('admin.withdrawals');
    Route::get('/admin/giveaways', [AdminController::class, 'giveaways'])->name('admin.giveaways');
    Route::delete('/admin/delete-user', [AdminController::class, 'delete_user'])->name('admin.delete-user');
    Route::post('/withdrawal/approve', [WithdrawalController::class, 'approve'])->name('withdrawal.approve');
    Route::post('/withdrawal/cancel', [WithdrawalController::class, 'cancel'])->name('withdrawal.cancel');
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
    Route::get('/tasks/yandex', 'yandex_reward')->name('tasks.yandex_reward');
});
Route::middleware('auth')->controller(UserTaskController::class)->group(function () {
    Route::get('/tasks/info', 'index')->name('tasks.user_task');
    Route::get('/tasks', 'dashboard');
    Route::post('/tasks/end-task', 'endTask')->name('tasks.end_task');
    Route::post('/tasks/start-task', 'start')->name('tasks.start');
});
