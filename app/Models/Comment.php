<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'date_time',
        'content',
    ];

    protected $primaryKey = 'id';

    // Eloquent relationship between User and Comment.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Eloquent relationship between Comment and Comment_Notification.
    public function commentNotification()
    {
        return $this->hasOne(Comment_Reaction::class);
    }	

    // Eloquent relationship between Comment and Post.
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
