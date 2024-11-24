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
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\ProfileController;

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
Route::redirect('/', '/home/trending');
Route::redirect('/home', '/home/trending');
Route::get('/home/trending', [HomeController::class, 'index'])->name('home.trending');
Route::get('/home/following', [HomeFollowingController::class, 'following'])->name('home.following');

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
Route::post('/home/*', [PostController::class, 'store'])->name('post.store');
Route::post('/groups/{group}', [PostController::class, 'store'])->name('post.store.group');

// Delete post
Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

// Groups
Route::redirect('/groups', '/groups/discover');
Route::get('/groups/discover', [HomeGroupsController::class, 'index'])->name('groups.discover');
Route::get('/groups/my-groups', [UserGroupsController::class, 'index'])->name('groups.my-groups');
Route::get('/groups/create', [GroupController::class, 'create'])
    ->middleware('auth') 
    ->name('groups.create'); 
Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
Route::get('/groups/{group}', [GroupController::class, 'index'])->name('groups.show');
Route::post('/groups/{group}/join', [GroupController::class, 'joinGroup'])->name('group.join');
Route::delete('/groups/{group}/leave', [GroupController::class, 'leaveGroup'])->name('group.leave');


// Reaction
Route::post('/reaction', [ReactionController::class, 'store'])->name('reaction.store');

// Profile
Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile.show');

// Edit Post
Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::post('/post/{post}/update', [PostController::class, 'update'])->name('post.update');
Route::redirect('/home', '/home/trending')->name('home');
