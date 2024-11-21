<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_Member extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Chat_Member';

    /* The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_id',
        'user_id'
    ];

    protected $primaryKey = 'id';

    // Eloquent relationship with user.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Eloquent relationship with chat.
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'id');
    }
}
