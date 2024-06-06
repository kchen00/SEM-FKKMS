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

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SaleReportController;
use App\Http\Controllers\ComplaintController;
use App\Models\Application;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $role = $user->role;

    if ($role == "student" || $role == "vendor") {
    	$participant = Participant::where("user_ID", $user->user_ID)->first();
	    $application = Application::where("parti_ID", $participant->parti_ID)->latest('created_at')->first();

        if (!$application) {
            return view("ManageUser.dashboard", ["has_application" => false, "application_status" => "none"]);
        } elseif ($application->status == "rejected") {
            return view("ManageUser.dashboard", ["has_application" => true, "application_status" => "rejected"]);
        } elseif ($application->status == "accepted") {
            return view("ManageUser.dashboard", ["has_application" => true, "application_status" => "accepted"]);
        } else {
            return view("ManageUser.dashboard", ["has_application" => true, "application_status" => "in_progress"]);
 
        }
    }

    return view("ManageUser.dashboard", ["has_application" => true, "application_status" => "none"]);
})->middleware("auth")->name('dashboard');

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'public_store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');

Route::prefix('application')->name('application.')->middleware(['auth', 'firstTimeLogin'])->group(function () {
    Route::get('/manage', [ApplicationController::class, 'index'])->name('manage');
    Route::get('/adminManage', [ApplicationController::class, 'adminManage'])->name('adminManage');
    Route::get('/edit/{id}', [ApplicationController::class, 'edit'])->name('edit');
    Route::get('/adminEdit/{id}', [ApplicationController::class, 'adminEdit'])->name('adminEdit');
    Route::post('/update/{id}', [ApplicationController::class, 'update'])->name('update');
    Route::post('/adminUpdate/{id}', [ApplicationController::class, 'adminUpdate'])->name('adminUpdate');
    Route::get('/show/{id}', [ApplicationController::class, 'show'])->name('show');
    Route::get('/create', [ApplicationController::class, 'create'])->name('create');
    Route::post('/store', [ApplicationController::class, 'store'])->name('store');
});


Route::prefix('rental')->name('rental')->middleware(['auth', 'firstTimeLogin', 'checkApplication'])->group(function () {
    Route::get('/', [RentalController::class, 'index'])->name('');
    Route::get('/adminManage', [RentalController::class, 'adminManage'])->name('.adminManage');
    Route::get('/edit/{id}', [RentalController::class, 'edit'])->name('.edit');
    Route::get('/adminEdit/{id}', [RentalController::class, 'adminEdit'])->name('.adminEdit');
    Route::post('/update/{id}', [RentalController::class, 'update'])->name('.update');
    Route::post('/adminUpdate/{id}', [RentalController::class, 'adminUpdate'])->name('.adminUpdate');
    Route::get('/show', [RentalController::class, 'show'])->name('.show');
});


Route::prefix('payment')->name('payment')->middleware(['auth', 'firstTimeLogin', 'checkApplication'])->group(function () {
    Route::get('/', [PaymentController::class, 'index'])->name('');
    Route::get('/create', [PaymentController::class, 'create'])->name('.create');
    Route::post('/store', [PaymentController::class, 'store'])->name('.store');
    Route::get('/bursaryManage', [PaymentController::class, 'bursaryManage'])->name('.bursaryManage');
    Route::get('/edit/{id}', [PaymentController::class, 'edit'])->name('.edit');
    Route::get('/bursaryEdit/{id}', [PaymentController::class, 'bursaryEdit'])->name('.bursaryEdit');
    Route::post('/update/{id}', [PaymentController::class, 'update'])->name('.update');
    Route::post('/bursaryUpdate/{id}', [PaymentController::class, 'bursaryUpdate'])->name('.bursaryUpdate');
    Route::get('/show/{id}', [PaymentController::class, 'show'])->name('.show');
});


Route::middleware(["auth", "firstTimeLogin"])->group(function() {
	Route::get('/fee', [FeeController::class, 'edit'])->name('fee');
	Route::post('/fee/update', [FeeController::class, 'update'])->name('fee.update');
	Route::get('documents/{fileName}', [ApplicationController::class, 'displayFile'])->name('file.display');
});

//manage sales report routes
Route::middleware(["auth", "firstTimeLogin", 'checkApplication'])->group(function () {
Route::get("/show-kiosk", [SaleReportController::class, 'show_kiosk'])
	->name("show-kiosk");

Route::get("/show-report", [SaleReportController::class, 'index'])
	->name("show-report")
	->middleware('checkApplication');

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

Route::group(['middleware' => ['auth', 'firstTimeLogin', 'checkApplication']], function () {
	Route::get('/complaintmenu', [ComplaintController::class, 'index'])->name('complaint-menu'); 
	Route::get('/complaintform', [ComplaintController::class, 'create'])->name('complaint-form');
	Route::get('/complaintview', [ComplaintController::class, 'show'])->name('complaint-shows');

	Route::get('/complaintviewTech', [ComplaintController::class, 'update'])->name('complaint.show');
	// In web.php or api.php
	Route::post('/ComplainStatus/{complaint_ID}', [ComplaintController::class, 'updatestat'])->name('complaint.status');
	Route::post('/ComplainStatus/{complaint_ID}/Solution', [ComplaintController::class, 'storeSolution'])->name('complaint.solution');
	
	Route::post('/complaintform', [ComplaintController::class, 'store'])->name('complaint-form.store');
	Route::delete('/complaint/{complaint_ID}', [ComplaintController::class, 'destroy'])->name('complaint.destroy');
	Route::get('/complaintReport', [ComplaintController::class, 'StoreReport'])->name('complaint-report');
});
	


//iman
use App\Http\Controllers\OtpController;

Route::get('/Mobile-Number', [OtpController::class, 'showMobileForm'])->name('enter.mobile');
Route::post('/send-otp', [OtpController::class, 'sendSMS'])->name('send.otp');
Route::get('/otp-verification', [OtpController::class, 'showVerificationForm'])->name('otp.verification');
Route::post('/otp-verify', [OtpController::class, 'verifyOTP'])->name('otp.verify.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');

