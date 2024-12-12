<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'User';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname',
        'username',
        'birth_date',
        'email',
        'bio',
        'profile_image',
        'banner_image',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $primaryKey = 'id';

    // Define relationships

    public function profileImage()
    {
        return $this->belongsTo(Image::class,'profile_image', 'id')->where('type', 'user_profile');
    }

    /**
     * Get the banner image associated with the user.
     */
    public function bannerImage()
    {
        return $this->belongsTo(Image::class, 'banner_image', 'id')->where('type', 'user_banner');
    }

    /**
     * Get the users that the user follows.
     */
    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id', 'id');
    }

    /**
     * Get the users that follow the user.
     */
    public function followers()
    {
        return $this->hasMany(Follow::class, 'followed_id', 'id');
    }

    /**
     * Get the messages that the user has sent.
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id', 'id');
    }

    /**
     * Get the posts that the user has saved.
     */
    public function savedPosts()
    {
        return $this->hasMany(Saved_Post::class, 'user_id', 'id');
    }

    /**
     * Get the posts that the user has reacted.
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'user_id', 'id');
    }

    /**
     * Get the posts that the user has reposted.
     */
    public function reposts()
    {
        return $this->hasMany(Repost::class, 'user_id', 'id');
    }

    /**
     * Get the join requests that the user has sent.
     */
    public function joinRequests()
    {
        return $this->hasMany(Join_Request::class, 'user_id', 'id');
    }

    /**
     * Get the notifications that the user has received.
     */
    public function reactionNotification()
    {
        return $this->hasMany(Reaction_Notification::class, 'user_id', 'id');
    }

    /**
     * Get the notifications that the user has received.
     */
    public function repostNotification()
    {
        return $this->hasMany(Repost_Notification::class, 'user_id', 'id');
    }

    /**
     * Get the notifications that the user has received.
     */
    public function followNotification()
    {
        return $this->hasMany(Follow_Notification::class, 'user_id', 'id');
    }

    /**
     * Get the notifications that the user has received.
     */
    public function messageNotification()
    {
        return $this->hasMany(Message_Notification::class, 'user_id', 'id');
    }

    /**
     * Get the notifications that the user has received.
     */
    public function joinRequestNotification()
    {
        return $this->hasMany(Join_Request_Notification::class, 'user_id', 'id');
    }

    /**
     * Get the comments that the user has received on a post.
     */
    public function commentNotification()
    {
        return $this->hasMany(Comment_Notification::class, 'user_id', 'id');
    }

    /**
     * Get the posts that the user has created.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    /**
     * Get the comments that the user has created.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    /**
     * Get the membership of the groups that the user is a member of.
     */
    public function groupMembers()
    {
        return $this->hasMany(Group_Member::class, 'user_id', 'id');
    }

    /**
     * Admin relationship
     */
    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'id');
    }

    /**
     * Get the membership of the chats that the user is a member of.
     */
    public function chatMembers()
    {
        return $this->hasMany(Chat_Member::class, 'user_id', 'id');
    }

    /**
     * Is the user an admin?
     */
    public function isAdmin()
    {
        return DB::table('Admin')->where('user_id', $this->id)->exists();
    }
}