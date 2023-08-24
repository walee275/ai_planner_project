<?php

use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PermissionController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PlanController;

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



// Route::controller(HomeController::class)->middleware(Authenticate::class)->group(function () {

//     Route::get('/', 'home')->name('home');
//     // Route::get('/home', 'home')->name('homepage');
// });

// Auth Routes::
Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware(Authenticate::class);

Route::controller(AuthController::class)->middleware(RedirectIfAuthenticated::class)->group(function () {

    Route::get('login', 'view')->name('login');
    Route::post('/login', 'login');


    Route::get('register', 'create')->name('register');
    Route::post('register', 'register');
});

// End Auth Routes::










Route::prefix('admin')->name('admin.')->middleware(Authenticate::class)->group(function () {

    Route::controller(AdminDashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    Route::controller(RoleController::class)->middleware('permission:manage roles and permissions')->group(function () {
        Route::get('/roles', 'index')->middleware('permission:read roles')->name('roles');
        Route::get('/roles/create', 'create')->middleware('permission:create role')->name('roles.create');
        Route::post('/roles/create', 'store')->middleware('permission:create role');
        Route::get('/role/update/{role}', 'edit')->middleware('permission:edit role')->name('roles.update');
        Route::post('/role/update/{role}', 'update')->middleware('permission:edit role');
        Route::get('/role/delete/{role}', 'destroy')->middleware('permission:delete roles')->name('roles.delete');
    });
    Route::controller(PermissionController::class)->middleware('permission:manage roles and permissions')->group(function () {
        Route::get('/permissions', 'index')->middleware('permission:read permissions')->name('permissions');
        Route::get('/permissions/create', 'create')->middleware('permission:create permission')->name('permissions.create');
        Route::post('/permissions/create', 'store')->middleware('permission:create permission');
        Route::get('/permission/update/{permission}', 'edit')->middleware('permission:edit permission')->name('permissions.update');
        Route::post('/permission/update/{permission}', 'update')->middleware('permission:edit permission');
        Route::get('/permission/delete/{permission}', 'destroy')->middleware('permission:delete permission')->name('permissions.delete');
    });

    Route::controller(UserController::class)->middleware('permission:manage users')->group(function () {
        Route::get('/users', 'index')->middleware('permission:read users')->name('users');
        Route::get('/user/create', 'create')->middleware('permission:create user')->name('user.create');
        Route::post('/user/create', 'store')->middleware('permission:create user');
        Route::get('/user/update/{user}', 'edit')->middleware('permission:edit user')->name('user.update');
        Route::post('/user/update/{user}', 'update')->middleware('permission:edit user');
        Route::get('/user/delete/{user}', 'destroy')->middleware('permission:delete user')->name('user.delete');
    });
});


Route::controller(PlanController::class)->middleware(Authenticate::class)->group(function () {

    Route::get('/', 'index')->name('homepage');
    Route::get('/create-plan', 'create')->name('create.plan');
    Route::get('/show-plans', 'show')->name('show.plans');
    Route::get('/api-test', 'store')->name('api-test');
});
