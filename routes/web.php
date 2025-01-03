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
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SavedController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PusherAuthController;
use App\Http\Controllers\RepostController;
use App\Http\Controllers\StaticPagesController;

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

Auth::routes(['verify' => true]);

// Groups:
Route::redirect('/groups', '/groups/discover');
// Show discover, my-groups, and create pages
Route::get('/groups/discover', [HomeGroupsController::class, 'index'])->name('groups.discover');
Route::get('/groups/my-groups', [UserGroupsController::class, 'index'])->name('groups.my-groups');
Route::get('/groups/create', [GroupController::class, 'create'])
    ->middleware('auth') 
    ->name('groups.create'); 
// Create group
Route::post('/dumb', [GroupController::class, 'store'])->name('group.store');
// Show a specific group
Route::get('/groups/{group}', [GroupController::class, 'index'])->name('group.show');
// Create a join request on a group
Route::post('/groups/{group}/join', [GroupController::class, 'joinGroup'])->name('group.join');
// Delete my id on group member's list
Route::delete('/groups/{group}/leave', [GroupController::class, 'leaveGroup'])->name('group.leave');
// Show edit a specific group page
Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])
    ->middleware('auth')
    ->name('group.edit');
// Update group after edit page
Route::put('/groups/{group}', [GroupController::class, 'update'])->name('group.update');
// Delete group
Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('group.destroy');
Route::get('/groups/{group}/management/members', [ManagementController::class,'manageMembers'])->name('group-management-members.index');
Route::get('/groups/{group}/management/requests', [ManagementController::class,'manageRequests'])->name('group-management-requests.index');
Route::post('/groups/{group}/management/add-member', [ManagementController::class,'addMember'])->name('group.addMember');
// Remove a member from a group
Route::delete('/groups/{group}/management/delete/{member}', [ManagementController::class,'removeMember'])->name('group.removeMember');
// Make a member a owner of the group
Route::post('/groups/{group}/management/make-owner/{member}', [ManagementController::class,'makeOwner'])->name('group.makeOwner');
Route::post('/groups/{group}/join-request', [GroupController::class, 'sendJoinRequest'])->name('group.join-request');
Route::delete('/groups/{group}/cancel-request', [GroupController::class, 'cancelJoinRequest'])->name('group.cancel-request');
// Route for accepting the request
Route::post('/groups/accept-request/{id}', [ManagementController::class, 'acceptRequest'])->name('group.accept-request');

// Route for declining the request
Route::post('/groups/decline-request/{id}', [ManagementController::class, 'declineRequest'])->name('group.decline-request');
// Interaction with other users:
// Reaction creation
Route::post('/reaction', [ReactionController::class, 'store'])->name('reaction.store');
// Follow User
Route::post('/profile/{id}/follow', [ProfileController::class, 'toggleFollow'])->name('profile.toggleFollow');

// Profile:
// Show profile of a user 
Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile.show');
// Edit Profile
Route::get('/profile/{username}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{username}/edit', [ProfileController::class, 'update'])->name('profile.update');
// Delete Profile
Route::delete('/profile/{username}', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');
Route::post('/profile/{username}/follow', [ProfileController::class, 'toggleFollow'])->name('profile.follow');
Route::post('/profile/{username}/follow-request', [ProfileController::class, 'toggleFollowRequest'])->name('profile.followRequest');
Route::get('/profile/{username}/management/followers', [ProfileController::class,'manageFollowers'])->name('profile.manageFollowers');
Route::get('/profile/{username}/management/requests', [ProfileController::class,'manageRequests'])->name('profile.manageRequests');
Route::delete('/profile/{username}/management/followers/remove-follower/{followerId}', [ProfileController::class, 'removeFollower'])->name('profile.removeFollower');
Route::delete('/profile/{username}/management/requests/remove-follower-request/{followerId}', [ProfileController::class, 'removeFollowRequest'])->name('profile.removeFollowRequest');
Route::post('/profile/{username}/management/requests/accept-follower-request/{followerId}', [ProfileController::class, 'acceptFollowRequest'])->name('profile.acceptFollowRequest');
// Direct Messages:
Route::post('/direct/create/{user}', [ChatController::class, 'create'])->name('chat.create');
Route::get('direct/inbox',[InboxController::class, 'index'])->name('inbox.index');
Route::get('/direct/{chat}', [ChatController::class, 'show'])->name('chat.show');
Route::post('/direct/{chat}', [ChatController::class, 'storeMessage'])->name('chat.storeMessage')->middleware('auth');;
// Posts:
// Edit Post
Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
// Create post
Route::post('/home/*', [PostController::class, 'store'])->name('post.store');
Route::post('/groups/{group}', [PostController::class, 'store'])->name('post.store.group');
// Delete post
Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
// Show Post's page by its ID
Route::get('/posts/{post}', [PostController::class, 'show'])->name('post.show');

// Comments:
// Create comment
Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
// Edit comment
Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comment.update');
// Delete comment
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

// Show administration page
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');
Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users')->middleware('auth');
Route::get('/admin/posts', [AdminController::class, 'posts'])->name('admin.posts')->middleware('auth');
Route::get('/admin/groups', [AdminController::class, 'groups'])->name('admin.groups')->middleware('auth');
Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports')->middleware('auth');
Route::get('/admin/users/search', [AdminController::class, 'searchUsers'])->name('admin.users.search')->middleware('auth');
Route::get('/admin/posts/search', [AdminController::class, 'searchPosts'])->name('admin.posts.search')->middleware('auth');
Route::get('/admin/groups/search', [AdminController::class, 'searchGroups'])->name('admin.groups.search')->middleware('auth');

// Show results page
Route::get('/results', [ResultsController::class, 'index'])->name('results');

// Saved posts
Route::get('/saved/{username}', [SavedController::class, 'index'])->name('saved.index');
Route::post('/saved/add/{post}', [SavedController::class,'create'])->name('saved.create');
Route::delete('/saved/remove/{post}', [SavedController::class,'destroy'])->name('saved.destroy');

// Reports
Route::get('/report/post/{post}', [ReportController::class, 'post'])->name('report.post');
Route::get('/report/comment/{comment}', [ReportController::class, 'comment'])->name('report.comment');
Route::get('/report/user/{user}', [ReportController::class, 'user'])->name('report.user');
Route::get('/report/group/{group}', [ReportController::class, 'group'])->name('report.group');
Route::post('/report', [ReportController::class, 'store'])->name('report.store');
Route::delete('/report/{report}', [ReportController::class, 'destroy'])->name('report.destroy');

// Notifications:
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index')->middleware('auth');
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead')->middleware('auth');

// Pusher Authentication ( For messages and notifications in the future)
Route::post('/pusher/auth', [PusherAuthController::class, 'authenticate']);

// Reposts
Route::post('/repost/{post}', [RepostController::class, 'store'])->name('repost.store');
Route::delete('/repost/{post}', [RepostController::class, 'destroy'])->name('repost.destroy');

//Static Pages
Route::get('/information/faq', [StaticPagesController::class,'faq'])->name('faq');
Route::get('/information/services', [StaticPagesController::class,'services'])->name('services');
Route::get('/information/about-us', [StaticPagesController::class,'aboutUs'])->name('about-us');
Route::get('/information/contacts', [StaticPagesController::class,'contacts'])->name('contacts');