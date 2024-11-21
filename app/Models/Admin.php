<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // Table that this model refers to.
    protected $table = 'Admin';

    protected $primaryKey = 'id';

    /**
     * Eloquent relationship with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
