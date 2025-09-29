<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AssociationController;
use App\Http\Controllers\Admin\BeneficiaryController;
use App\Http\Controllers\Admin\AidController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');


// API routes for associations
Route::middleware('auth:sanctum')->name('admin.associations.')->group(function () {
    Route::get('/associations', [AssociationController::class, 'index'])->name('index');       // كل الجمعيات
    Route::post('/associations', [AssociationController::class, 'store'])->name('store');  
    Route::get('/associations/create', [AssociationController::class, 'create'])->name('create');
        Route::get('/associations/edit/{association}', [AssociationController::class, 'edit'])->name('edit');    // إنشاء جمعية
    // إنشاء جمعية
    Route::get('/associations/{association}', [AssociationController::class, 'show'])->name('show'); // عرض جمعية واحدة
    Route::put('/associations/{association}', [AssociationController::class, 'update'])->name('update'); // تعديل
    Route::delete('/associations/{association}', [AssociationController::class, 'destroy'])->name('destroy'); // حذف
});



// ✅ Auth Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth:sanctum'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('beneficiaries', BeneficiaryController::class);
});
Route::prefix('admin')->name('admin.')->middleware('auth:sanctum')->group(function () {
    Route::resource('aids', AidController::class);
});


Route::middleware('auth:sanctum')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserController::class);
    });



Route::middleware('auth:sanctum')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
use App\Http\Controllers\User\AidController as UserAidController;
use App\Http\Controllers\User\BeneficiaryController as UserBeneficiaryController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\UsersController;

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::resource('users', UsersController::class);
});
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::resource('aids', UserAidController::class)->only([
    'index','create','store','show','edit','update'
]);

});


Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::resource('beneficiaries', UserBeneficiaryController::class)
         ->only(['index','create','store','show', 'edit' , 'update']);
});
Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
             ->name('dashboard.index');

        // Route::post('/dashboard/add-user', [UserDashboardController::class, 'storeUser'])
        //      ->name('dashboard.add-user');
    });

