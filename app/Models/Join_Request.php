<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Join_Request extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'join_request';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'group_id',
    ];

    protected $primaryKey = 'id';

    // Eloquent relationship to User model.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Eloquent relationship to Group model.
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
