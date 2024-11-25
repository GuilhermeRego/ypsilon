<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction_Notification extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Reaction_Notification';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reaction_id',
        'is_read',
        'date_time',
        'notified_id'
    ];

    protected $primaryKey = 'id';

    // Define Eloquent relationship to Reaction model.
    public function reaction()
    {
        return $this->belongsTo(Reaction::class, 'reaction_id', 'id');
    }

    // Define Eloquent relationship to User model.
    public function user()
    {
        return $this->belongsTo(User::class, 'notified_id', 'id');
    }
}
