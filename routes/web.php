<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\MailOutController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TechnicalCaseController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\TechnicalDirectiveController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

    

    //# ADMIN PAGES
	//only those have manage_users permission will get access
	Route::group(['middleware' => 'can:manage_users'], function(){
        Route::get('/users', [UserController::class,'index']);
        Route::get('/user/get-list', [UserController::class,'getUserList']);
        Route::get('/user/create', [UserController::class,'create']);
        Route::post('/user/create', [UserController::class,'store'])->name('create-user');  // POST create form
        Route::get('/user/{id}', [UserController::class,'edit']);
        Route::post('/user/update', [UserController::class,'update']);
        Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_roles permission will get access
	Route::group(['middleware' => 'can:manage_roles|manage_users'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permissions permission will get access
	Route::group(['middleware' => 'can:manage_permissions|manage_roles'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);


	// permission examples
    // Route::get('/permission-example', function () {
    // 	return view('permission-example'); 
    // });
    // API Documentation
    // Route::get('/rest-api', function () { return view('api'); });
    // Editable Datatable
	// Route::get('/table-datatable-edit', function () { 
	// 	return view('pages.datatable-editable'); 
	// });

    
	
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




    //# HOME 
    Route::get('/home', [HomeController::class,'dashboard'])->name('home')->middleware('auth');
    Route::get('/dashboard', [HomeController::class,'dashboard'])->name('dashboard')->middleware('auth');

    
    
    //# TECHNICAL DIRECTIVES
    Route::get('/technical_directives/create', [TechnicalDirectiveController::class,'create'])->name('directives.create')->middleware('can:manage_directives');
    Route::get('/technical_directives/{directive_id}/edit', [TechnicalDirectiveController::class,'edit'])->name('directives.edit')->middleware('can:manage_directives');

    Route::post('/technical_directives', [TechnicalDirectiveController::class,'store'])->name('directives.store')->middleware('can:manage_directives');
    Route::put('/technical_directives/{directive_id}', [TechnicalDirectiveController::class,'update'])->name('directives.update')->middleware('can:manage_directives');
    Route::delete('/technical_directives/{directive_id}', [TechnicalDirectiveController::class,'destroy'])->name('directives.destroy')->middleware('can:manage_directives');
    
    Route::get('/technical_directives/{directive_id}', [TechnicalDirectiveController::class,'show'])->name('directives.show')->middleware('can:view_directives');
    Route::get('/technical_directives', [TechnicalDirectiveController::class,'index'])->name('directives.index')->middleware('can:view_directives');



   //# TECHNICAL CASES
    Route::get('/technical_cases/create', [TechnicalCaseController::class,'create'])->name('cases.create')->middleware('can:create_cases');
    Route::get('/technical_cases/{case_id}/edit', [TechnicalCaseController::class,'edit'])->name('cases.edit')->middleware('can:create_cases');
    Route::get('/technical_cases/{case_id}/review', [TechnicalCaseController::class,'review'])->name('cases.review')->middleware('can:review_cases');
    Route::get('/technical_cases/{case_id}/files', [TechnicalCaseController::class,'files'])->name('directives.files')->middleware('can:review_cases');

    Route::post('/technical_cases/create', [TechnicalCaseController::class,'store'])->name('cases.store')->middleware('can:create_cases');
    Route::put('/technical_cases/{case_id}/update', [TechnicalCaseController::class,'update'])->name('cases.update')->middleware('can:create_cases');
    Route::put('/technical_cases/{case_id}/revise', [TechnicalCaseController::class,'revise'])->name('cases.revise')->middleware('can:review_cases');
    Route::delete('/technical_cases/{case_id}/deletefile/{filename}', [TechnicalCaseController::class,'destroyfile'])->name('cases.destroyfile')->middleware('can:create_cases');

    Route::get('/technical_cases/all', [TechnicalCaseController::class,'index'])->name('cases.index')->middleware('can:view_cases_basic');
    Route::get('/technical_cases/pending', [TechnicalCaseController::class,'indexpending'])->name('cases.indexpending')->middleware('can:view_cases_basic');
    Route::get('/technical_cases/{case_id}', [TechnicalCaseController::class,'show'])->name('directives.show')->middleware('can:view_cases_full');

    Route::post('/api/messageToFactory', [TechnicalCaseController::class,'messageToFactory'])->name('directives.factory')->middleware('can:communicate_with_factory');



    //# REPORTS
    Route::get('/reports/vins', [ReportsController::class,'casespervin'])->name('reports.vins')->middleware('can:view_reports');



    //# TESTS
    Route::get('/test', [TestController::class,'test'])->name('test.new')->middleware('auth');



    //! TO FIX
    //only those have manage_roles permission will get access
	Route::group(['middleware' => 'can:manage_roles|manage_users'], function(){
    //settings
    Route::get('/app_settings', [SettingsController::class,'index'])->name('show_settings')->middleware('auth');
    Route::post('/app_settings', [SettingsController::class,'create'])->name('store_settings')->middleware('auth');


    // support 
    // Route::get('/support_tickets/create', function () { return view('support.support_tickets.create'); }); 
    // Route::get('/support_tickets', function () { return view('support.support_tickets.list'); });
    // Route::get('/warranty_claims/create', function () { return view('support.warranty_claims.create'); }); 
    // Route::get('/warranty_claims', function () { return view('support.warranty_claims.list'); });






    //Reports













});