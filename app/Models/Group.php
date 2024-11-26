<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    // Table that this model refers to.
    protected $table = 'Group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'group_image',
        'group_banner',
    ];

    protected $primaryKey = 'id';

    // Eloquent relationship with Group_Member.
    public function group_member()
    {
        return $this->hasMany(Group_Member::class, 'group_id', 'id');
    }
    public function memberCount() {
        return $this->group_member()->count();
    }

    // Eloquent relationship with Post.
    public function post()
    {
        return $this->hasMany(Post::class, 'group_id', 'id');
    }

    // Eloquent relationship with Join_Request.
    public function join_request()
    {
        return $this->hasMany(Join_Request::class, 'group_id', 'id');
    }

    // Eloquent relationship with Image (group_image).
    public function groupImage()
    {
    return $this->belongsTo(Image::class, 'group_image', 'id')->where('type', 'group_profile');
    }
    // Eloquent relationship with Image (group_banner).
    public function groupBanner()
    {
        return $this->belongsTo(Image::class, 'group_banner', 'id')->where('type', 'group_banner');
    }
}
