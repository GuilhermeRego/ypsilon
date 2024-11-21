<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Reaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'is_like',
    ];

    protected $primaryKey = 'id';

    // Define Eloquent relationship to User model.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Define Eloquent relationship to Reaction_Notification model.
    public function reaction_notification()
    {
        return $this->hasOne(Reaction_Notification::class, 'reaction_id', 'id');
    }

    // Define Eloquent relationship to Post model.
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
