<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repost extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'repost';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'created_at',
    ];

    protected $primaryKey = 'id';

    // Eloquent relationship to User model.
    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    // Eloquent relationship to Repost_Notification model.
    public function repost_notification()
    {
        return $this->hasOne(Repost_Notification::class, 'repost_id', 'id');
    }

    // Eloquent relationship to Post model.
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
