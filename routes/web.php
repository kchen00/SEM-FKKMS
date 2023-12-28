<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your  These
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
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SaleReportController;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
	return redirect('/dashboard');
})->middleware('auth');

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'public_store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');

Route::view('/dashboard', "ManageUser.dashboard")->middleware(["auth", "firstTimeLogin"])->name('home');

Route::prefix('application')->name('application.')->group(function () {
	Route::get('/manage', [ApplicationController::class, 'index'])->middleware('auth')->name('manage');
	Route::get('/adminManage', [ApplicationController::class, 'adminManage'])->middleware('auth')->name('adminManage');
	Route::get('/create', [ApplicationController::class, 'create'])->middleware('auth')->name('create');
	Route::get('/edit/{id}', [ApplicationController::class, 'edit'])->middleware('auth')->name('edit');
	Route::get('/adminEdit/{id}', [ApplicationController::class, 'adminEdit'])->middleware('auth')->name('adminEdit');
	Route::post('/store', [ApplicationController::class, 'store'])->middleware('auth')->name('store');
	Route::post('/update/{id}', [ApplicationController::class, 'update'])->middleware('auth')->name('update');
	Route::post('/adminUpdate/{id}', [ApplicationController::class, 'adminUpdate'])->middleware('auth')->name('adminUpdate');
	Route::get('/show', [ApplicationController::class, 'show'])->middleware('auth')->name('show');   
});
Route::prefix('rental')->name('application.')->group(function () {
	Route::get('/', [RentalController::class, 'index'])->middleware('auth')->name('');
	Route::get('/adminManage', [RentalController::class, 'adminManage'])->middleware('auth')->name('adminManage');
	Route::get('/edit/{id}', [RentalController::class, 'edit'])->middleware('auth')->name('edit');
	Route::get('/adminEdit/{id}', [RentalController::class, 'adminEdit'])->middleware('auth')->name('adminEdit');
	Route::post('/update/{id}', [RentalController::class, 'update'])->middleware('auth')->name('update');
	Route::post('/adminUpdate/{id}', [RentalController::class, 'adminUpdate'])->middleware('auth')->name('adminUpdate');
	Route::get('/show', [RentalController::class, 'show'])->middleware('auth')->name('show');
});
// Route::get('/rental', [RentalController::class, 'index'])->middleware('auth')->name('rental');
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
Route::middleware(["auth", "firstTimeLogin"])->group(function () {
Route::get("/show-kiosk", [SaleReportController::class, 'show_kiosk'])
	->name("show-kiosk");

Route::get("/show-report", [SaleReportController::class, 'index'])
	->name("show-report");

Route::get('/admin-show-report/{participant_id}/{kiosk_id}/{kiosk_owner}', [SaleReportController::class, 'admin_index'])
    ->name('admin-show-report');

Route::post("/add-comment", [SaleReportController::class, "add_comment"])
	->name("add-comment");
});

Route::post("/submit-report", [SaleReportController::class, 'store'])
	->name("submit-sale-report");

Route::post("/update-report", [SaleReportController::class, 'update'])
	->name("update-sale-report");



// manage users routes
Route::middleware(["auth", "firstTimeLogin"])->group(function () {
	Route::get('/admin-add-user', [RegisterController::class, "admin_create"])
		->name('admin-add-user');
	
	Route::post('/admin-add-user', [RegisterController::class, "admin_store"])
		->name('admin-add-user.perform');
});
	
	
Route::get('/admin-force-reset', [ResetPassword::class, "admin_show"])
	->middleware("auth")
	->name('admin-force-reset');
	
Route::post('/admin-force-reset', [ChangePassword::class, "update"])
	->name('admin-force-reset.perform');