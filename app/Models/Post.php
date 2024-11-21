<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    // Table that this model refers to.
    protected $table = 'post';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',   
        'date_time',
        'content',
        'group_id',
    ];

    protected $primaryKey = 'id';

    // Eloquent relationship between User and Post.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Eloquent relationship between Post and Comment.
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    // Eloquent relationship between Post and Group.
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    // Eloquent relationship between Post and Saved_Post.
    public function saved_post()
    {
        return $this->hasMany(Saved_Post::class, 'post_id', 'id');
    }

    // Eloquent relationship between Post and Reaction.
    public function reaction()
    {
        return $this->hasMany(Reaction::class, 'post_id', 'id');
    }

    // Eloquent relationship between Post and Repost.
    public function repost()
    {
        return $this->hasMany(Repost::class, 'post_id', 'id');
    }
}
