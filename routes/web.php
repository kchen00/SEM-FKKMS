<?php

use App\Http\Controllers\ApplicationController;
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

Route::get('/', function () {
	return redirect('/dashboard');
})->middleware('auth');
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::view('/dashboard', 'ManageUser.dashboard')->name('home')->middleware('auth');
Route::get('/application/manage', [ApplicationController::class, 'index'])->middleware('auth')->name('application.manage');
Route::get('/application/adminManage', [ApplicationController::class, 'adminManage'])->middleware('auth')->name('application.adminManage');
Route::get('/application/create', [ApplicationController::class, 'create'])->middleware('auth')->name('application.create');
Route::get('/application/edit/{id}', [ApplicationController::class, 'edit'])->middleware('auth')->name('application.edit');
Route::get('/application/adminEdit/{id}', [ApplicationController::class, 'adminEdit'])->middleware('auth')->name('application.adminEdit');
Route::post('/application/store', [ApplicationController::class, 'store'])->middleware('auth')->name('application.store');
Route::post('/application/update/{id}', [ApplicationController::class, 'update'])->middleware('auth')->name('application.update');
Route::post('/application/adminUpdate/{id}', [ApplicationController::class, 'adminUpdate'])->middleware('auth')->name('application.adminUpdate');
Route::get('/application/show', [ApplicationController::class, 'show'])->middleware('auth')->name('application.show');
Route::get('documents/{fileName}', [ApplicationController::class, 'displayFile'])->name('file.display');


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
Route::get("/show-report", [SaleReportController::class, 'index'])->middleware("auth")->name("show-report");
