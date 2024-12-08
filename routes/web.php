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
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\Groups\ManagementController;

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
Route::redirect('/home', '/home/trending')->name('home');
Route::get('/home/trending', [HomeController::class, 'index'])->name('home.trending');
Route::get('/home/following', [HomeFollowingController::class, 'following'])->name('home.following');
Route::get('/home/search-users', [UserController::class, 'search'])->name('home.search.users');

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
Route::post('/dumb', [GroupController::class, 'store'])->name('group.store');
Route::get('/groups/{group}', [GroupController::class, 'index'])->name('group.show');
Route::post('/groups/{group}/join', [GroupController::class, 'joinGroup'])->name('group.join');
Route::delete('/groups/{group}/leave', [GroupController::class, 'leaveGroup'])->name('group.leave');
Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])
    ->middleware('auth')
    ->name('group.edit');
Route::put('/groups/{group}', [GroupController::class, 'update'])->name('group.update');
Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('group.destroy');
Route::get('/groups/{group}/management/members', [ManagementController::class,'manageMembers'])->name('group-management-members.index');
Route::get('/groups/{group}/management/requests', [ManagementController::class,'manageRequests'])->name('group-management-requests.index');
Route::post('/groups/{group}/management/add-member', [ManagementController::class,'addMember'])->name('group.addMember');
Route::delete('/groups/{group}/management/delete/{member}', [ManagementController::class,'removeMember'])->name('group.removeMember');
Route::post('/groups/{group}/management/make-owner/{member}', [ManagementController::class,'makeOwner'])->name('group.makeOwner');
Route::post('/groups/{group}/join-request', [GroupController::class, 'sendJoinRequest'])->name('group.join-request');
Route::delete('/groups/{group}/cancel-request', [GroupController::class, 'cancelJoinRequest'])->name('group.cancel-request');

// Reaction
Route::post('/reaction', [ReactionController::class, 'store'])->name('reaction.store');

// Profile
Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile.show');

// Edit Profile
Route::get('/profile/{username}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{username}/edit', [ProfileController::class, 'update'])->name('profile.update');

// Delete Profile
Route::delete('/profile/{username}', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');

// Follow User
Route::post('/profile/{id}/follow', [ProfileController::class, 'toggleFollow'])->name('profile.toggleFollow');

// Edit Post
Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::post('/post/{post}/update', [PostController::class, 'update'])->name('post.update');

// Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');

// Results
Route::get('/results', [ResultsController::class, 'index'])->name('results');
