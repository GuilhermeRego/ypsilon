<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_Owner extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    // The table associated with the model.
    protected $table = 'group_owner';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
    ];

    protected $primaryKey = 'id';
    
    // Eloquent relationship with Group_Member.
    public function group_member()
    {
        return $this->belongsTo(Group_Member::class, 'member_id', 'user_id');
    }
}
