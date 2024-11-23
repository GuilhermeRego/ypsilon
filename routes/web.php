<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Groups\HomeGroupsController;
use App\Http\Controllers\Groups\UserGroupsController;
use App\Http\Controllers\Groups\GroupController;
use App\Http\Controllers\HomeFollowingController;

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



// Home
Route::redirect('/','/home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::redirect('/', '/login');
Route::get('/trending', [HomeController::class, 'index'])->name('home');

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

// Registration
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// Create post
Route::post('/home', [PostController::class, 'store'])->name('post.store');

// Groups
Route::redirect('/groups', '/groups/discover');
Route::get('/groups/discover', [HomeGroupsController::class, 'index']);
Route::get('/groups/your-groups', [UserGroupsController::class, 'index'])
    ->middleware('auth')
    ->name('your-groups.index');
Route::get('/group/create', [GroupController::class, 'create'])
    ->middleware('auth')
    ->name('group.create');
Route::post('/group/create', [GroupController::class, 'store'])->name('group.store');



// Following
Route::get('/following', [HomeFollowingController::class, 'following'])->name('home.following');
