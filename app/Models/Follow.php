<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Follow';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'follower_id',
        'followed_id',
    ];

    protected $primaryKey = 'id';

    /**
     * Get the user that owns the follower.
     */
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id', 'id');
    }

    /**
     * Get the user that owns the followed.
     */
    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id', 'id');
    }
}
