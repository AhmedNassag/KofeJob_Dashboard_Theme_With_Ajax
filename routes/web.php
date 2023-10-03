<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);
Route::get('/home', [HomeController::class, 'index'])->name('home');


/****************************** START ADMIN ROUTES ******************************/
Route::Group(['prefix' => 'admin', 'middleware' => 'auth'], function () { 

    //roles
    Route::resource('role', RoleController::class);
    Route::post('roleDelete', [RoleController::class, 'delete'])->name('role.delete');


    //user
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('userDeleteSelected', [UserController::class, 'deleteSelected'])->name('user.deleteSelected');
    Route::get('userShowNotification/{id}', [UserController::class, 'showNotification'])->name('user.showNotification');   
    Route::get('userChangeStatus/{id}', [UserController::class, 'changeStatus'])->name('user.changeStatus');


    //category
    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category/fetch', [CategoryController::class, 'fetch'])->name('category.fetch');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::post('categoryDeleteSelected', [CategoryController::class, 'deleteSelected'])->name('category.deleteSelected');
    Route::get('categoryShowNotification/{id}/{notification_id}', [CategoryController::class, 'showNotification'])->name('category.showNotification');



    //general routes
    Route::get('show_file/{folder_name}/{photo_name}', [GeneralController::class, 'show_file'])->name('show_file');
    Route::get('download_file/{folder_name}/{photo_name}', [GeneralController::class, 'download_file'])->name('download_file');
    Route::get('allNotifications', [GeneralController::class, 'allNotifications'])->name('allNotifications');
    Route::get('markAllAsRead', [GeneralController::class, 'markAllAsRead'])->name('markAllAsRead');

    

    Route::get('/index_admin', function () { return view('admin.index_admin'); })->name('index_admin');
    Route::get('/bid-fees', function () { return view('admin.bid-fees'); })->name('bid-fees');
    Route::get('/change-password', function () { return view('admin.change-password'); })->name('change-password');
    Route::get('/components', function () { return view('admin.components'); })->name('components');
    Route::get('/contest-entry-fees', function () { return view('admin.contest-entry-fees'); })->name('contest-entry-fees');
    Route::get('/contests-fees', function () { return view('admin.contests-fees'); })->name('contests-fees');
    Route::get('/data-tables', function () { return view('admin.data-tables'); })->name('data-tables');
    Route::get('/delete-account', function () { return view('admin.delete-account'); })->name('delete-account');
    Route::get('/email-settings', function () { return view('admin.email-settings'); })->name('email-settings');
    Route::get('/fees', function () { return view('admin.fees'); })->name('fees');
    Route::get('/forgot-password', function () { return view('admin.forgot-password'); })->name('forgot-password');
    Route::get('/form-basic-inputs', function () { return view('admin.form-basic-inputs'); })->name('form-basic-inputs');
    Route::get('/form-horizontal', function () { return view('admin.form-horizontal'); })->name('form-horizontal');
    Route::get('/form-input-groups', function () { return view('admin.form-input-groups'); })->name('form-input-groups');
    Route::get('/form-mask', function () { return view('admin.form-mask'); })->name('form-mask'); 
    Route::get('/form-validation', function () { return view('admin.form-validation'); })->name('form-validation'); 
    Route::get('/form-vertical', function () { return view('admin.form-vertical'); })->name('form-vertical'); 
    Route::get('/localization-details', function () { return view('admin.localization-details'); })->name('localization-details');
    // Route::get('/register', function () { return view('admin.register'); })->name('register');
    // Route::get('/login', function () { return view('admin.login'); })->name('login');
    Route::get('/others-settings', function () { return view('admin.others-settings'); })->name('others-settings');
    Route::get('/payment-settings', function () { return view('admin.payment-settings'); })->name('payment-settings');
    Route::get('/payment-settings', function () { return view('admin.payment-settings'); })->name('payment-settings');
    Route::get('/profile', function () { return view('admin.profile'); })->name('profile');
    Route::get('/projects', function () { return view('admin.projects'); })->name('projects');
    Route::get('/projects-fees', function () { return view('admin.projects-fees'); })->name('projects-fees');
    Route::get('/providers', function () { return view('admin.providers'); })->name('providers');
    Route::get('/reports', function () { return view('admin.reports'); })->name('reports');
    Route::get('/roles', function () { return view('admin.roles'); })->name('roles');
    Route::get('/roles-permission', function () { return view('admin.roles-permission'); })->name('roles-permission');
    Route::get('/seo-settings', function () { return view('admin.seo-settings'); })->name('seo-settings');
    Route::get('/settings', function () { return view('admin.settings'); })->name('settings');
    Route::get('/skills', function () { return view('admin.skills'); })->name('skills');
    Route::get('/social-links', function () { return view('admin.social-links'); })->name('social-links');
    Route::get('/social-settings', function () { return view('admin.social-settings'); })->name('social-settings');
    Route::get('/sub-category', function () { return view('admin.sub-category'); })->name('sub-category');
    Route::get('/tables-basic', function () { return view('admin.tables-basic'); })->name('tables-basic');
    Route::get('/taxs', function () { return view('admin.taxs'); })->name('taxs');
    Route::get('/tax-types', function () { return view('admin.tax-types'); })->name('tax-types');
    Route::get('/users', function () { return view('admin.users'); })->name('users');
    Route::get('/verify-identity', function () { return view('admin.verify-identity'); })->name('verify-identity');
    Route::get('/view-estimate', function () { return view('admin.view-estimate'); })->name('view-estimate');
    Route::get('/view-invoice', function () { return view('admin.view-invoice'); })->name('view-invoice');
});
/****************************** END ADMIN ROUTES ******************************/