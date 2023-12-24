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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\SaleReportController;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	Route::view('/dashboard', 'ManageUser.dashboard')->name('home')->middleware('auth');
	
Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static'); 
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static'); 
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

//manage sales report routes
Route::get("/show-kiosk", [SaleReportController::class, 'show_kiosk'])
	->middleware("auth")
	->name("show-kiosk");

Route::get("/show-report", [SaleReportController::class, 'index'])
	->middleware("auth")
	->name("show-report");

Route::get('/admin-show-report/{participant_id}/{kiosk_id}/{kiosk_owner}', [SaleReportController::class, 'admin_index'])
    ->middleware('auth')
    ->name('admin-show-report');

Route::post("/submit-report", [SaleReportController::class, 'store'])
	->name("submit-sale-report");

Route::post("/update-report", [SaleReportController::class, 'update'])
	->name("update-sale-report");

Route::post("/add-comment", [SaleReportController::class, "add_comment"])->name("add-comment");