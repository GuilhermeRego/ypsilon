<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Message';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_id',
        'sender_id',
        'content',
        'date_time'
    ];

    protected $primaryKey = 'id';

    // Eloquent relation to get the chat that this message belongs to.
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    // Eloquent relation to get the chat that this message belongs to.
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'id');
    }
}
