<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TechnicalReportController;
use App\Http\Controllers\MailOutController;
use App\Http\Controllers\TechnicalDirectiveController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReportsController;

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
Route::get('/', function () { return view('auth.login'); });
// Route::get('test', [HomeController::class,'test'])->name('test');

Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);

Route::get('password/forget',  function () { 
	return view('pages.forgot-password'); 
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');



//* ONLY FOR LOGGED ON USERS
Route::group(['middleware' => 'auth'], function(){
	
    //* USER PAGES
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);
    Route::get('/myprofile', [UserController::class,'editmyprofile'])->name('myprofile');
    Route::post('/myprofile/update', [UserController::class,'updateprofile'])->name('updateprofile');

    

    //* ADMIN PAGES
	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
        Route::get('/users', [UserController::class,'index']);
        Route::get('/user/get-list', [UserController::class,'getUserList']);
        Route::get('/user/create', [UserController::class,'create']);
        Route::post('/user/create', [UserController::class,'store'])->name('create-user');  // POST create form
        Route::get('/user/{id}', [UserController::class,'edit']);
        Route::post('/user/update', [UserController::class,'update']);
        Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);


	// permission examples
    Route::get('/permission-example', function () {
    	return view('permission-example'); 
    });
    // API Documentation
    Route::get('/rest-api', function () { return view('api'); });
    // Editable Datatable
	Route::get('/table-datatable-edit', function () { 
		return view('pages.datatable-editable'); 
	});

    
	
});


    // Route::get('/register', function () { return view('pages.register'); });





    // Themekit demo pages
    Route::get('/calendar', function () { return view('pages.calendar'); });
    Route::get('/charts-amcharts', function () { return view('pages.charts-amcharts'); });
    Route::get('/charts-chartist', function () { return view('pages.charts-chartist'); });
    Route::get('/charts-flot', function () { return view('pages.charts-flot'); });
    Route::get('/charts-knob', function () { return view('pages.charts-knob'); });
    Route::get('/forgot-password', function () { return view('pages.forgot-password'); });
    Route::get('/form-addon', function () { return view('pages.form-addon'); });
    Route::get('/form-advance', function () { return view('pages.form-advance'); });
    Route::get('/form-components', function () { return view('pages.form-components'); });
    Route::get('/form-picker', function () { return view('pages.form-picker'); });
    Route::get('/invoice', function () { return view('pages.invoice'); });
    Route::get('/layout-edit-item', function () { return view('pages.layout-edit-item'); });
    Route::get('/layouts', function () { return view('pages.layouts'); });




    //* HOME 
    Route::get('/home', [HomeController::class,'dashboard'])->name('home')->middleware('auth');
    Route::get('/dashboard', [HomeController::class,'dashboard'])->name('dashboard')->middleware('auth');

    // support 
    Route::get('/support_tickets/create', function () { return view('support.support_tickets.create'); }); 
    Route::get('/support_tickets', function () { return view('support.support_tickets.list'); });
    Route::get('/warranty_claims/create', function () { return view('support.warranty_claims.create'); }); 
    Route::get('/warranty_claims', function () { return view('support.warranty_claims.list'); });


    //* TECHNICAL REPORTS
    Route::get('/technical_reports/create', [TechnicalReportController::class,'show_create'])->name('show_create_technical_reports')->middleware('auth');
    Route::post('/technical_reports/create', [TechnicalReportController::class,'create'])->name('create_technical_reports')->middleware('auth');
    Route::get('/technical_reports/list', [TechnicalReportController::class,'getTechnicalReportList'])->name('technical_reports.index')->middleware('auth');
    Route::get('technical_reports/reportt_view_form_modal', [TechnicalReportController::class,'fetch_TechnicalReport_modal_view'])->name('technicalReport_modal_view')->middleware('auth');//json request
    Route::get('/technical_reports/toedit/{id}', [TechnicalReportController::class,'show_edit'])->name('show_edit_technical_reports')->middleware('auth');
    Route::post('/technical_reports/update_new_message', [TechnicalReportController::class,'update_new_message'])->name('update_edit_technical_reports')->middleware('auth');
    Route::post('/technical_reports/update_summary', [TechnicalReportController::class,'update_summary'])->name('update_summary_technical_reports')->middleware('auth');

    Route::post('/technical_reports/send_vendor_message', [TechnicalReportController::class,'send_vendor_message'])->name('send_vendor_message')->middleware('auth');

    Route::get('/technical_reports/fetch_select_children', [TechnicalReportController::class,'fetch_select_children'])->name('fetch_select_children')->middleware('auth');
    Route::get('/technical_reports/fetch_model_for_vin', [TechnicalReportController::class,'fetch_model_for_vin'])->name('fetch_model_for_vin')->middleware('auth');



    // technical_reports 
    // Route::get('/technical_reports/get-list', [TechnicalReportController::class,'getTechnicalReportList2']);//datatables 
    // Route::get('/technical_directives', function () { return view('support.technical_directives.list'); }); 






    //* TECHNICAL DIRECTIVES
    Route::get('/technical_directives/create', [TechnicalDirectiveController::class,'create'])->name('create_technical_directives')->middleware('auth');
    Route::post('/technical_directives/create', [TechnicalDirectiveController::class,'store'])->name('store_technical_directives')->middleware('auth');
    Route::get('/technical_directives/list', [TechnicalDirectiveController::class,'getTechnicalDirectiveList'])->name('technical_directives.index')->middleware('auth');
    Route::get('/technical_directives/{directive_id}', [TechnicalDirectiveController::class,'show'])->name('show_technical_directive')->middleware('auth');

    //only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
    //settings
    Route::get('/app_settings', [SettingsController::class,'index'])->name('show_settings')->middleware('auth');
    Route::post('/app_settings', [SettingsController::class,'create'])->name('store_settings')->middleware('auth');

    //settings



    //Reports
    Route::get('/reports/vin_search', [ReportsController::class,'vin_search'])->name('vin_search')->middleware('auth');

    //Reports













});