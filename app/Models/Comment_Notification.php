<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_Notification extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Comment_Notification';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment_id',
        'is_read',
        'date_time',
        'notified_id'
    ];

    protected $primaryKey = 'id';

    // Eloquent relationship with Comment model.
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

    // Eloquent relationship with User model.
    public function user()
    {
        return $this->belongsTo(User::class, 'notified_id', 'id');
    }
}
