<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message_Notification extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Message_Notification';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message_id',
        'is_read',
        'date_time',
        'notified_id'
    ];

    protected $primaryKey = 'id';

    // Define Eloquent relationship to User model.
    public function user()
    {
        return $this->belongsTo(User::class, 'notified_id', 'id');
    }

    // Define Eloquent relationship to Message model.
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }
}
