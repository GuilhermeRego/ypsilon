<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saved_Post extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Saved_Post';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id'
    ];

    protected $primaryKey = 'id';

    /**
     * Get the user that saved the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the post that was saved.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
