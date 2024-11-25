<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Chat';

    protected $primaryKey = 'id';

    // Eloquent relationship with chat_member.
    public function chat_member()
    {
        return $this->hasMany(Chat_Member::class, 'chat_id', 'id');
    }

    // Eloquent relationship with message.
    public function message()
    {
        return $this->hasMany(Message::class, 'chat_id', 'id');
    }
}
