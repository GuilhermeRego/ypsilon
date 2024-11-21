<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Image extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    // Table that this model refers to.
    protected $table = 'Image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'type',
    ];

    protected $primaryKey = 'id';

    /**
     * Get the user that owns the profile image.
     */
    public function userProfile()
    {
        return $this->belongsTo(User::class, 'profile_image', 'id')->where('type', 'user_profile');
    }

    /**
     * Get the user that owns the banner image.
     */
    public function userBanner()
    {
        return $this->belongsTo(User::class, 'banner_image', 'id')->where('type', 'user_banner');
    }

    /**
     * Get the group that owns the group image.
     */
    public function groupImage()
    {
        return $this->belongsTo(Group::class, 'group_image', 'id')->where('type', 'group_image');
    }

    /**
     * Get the group that owns the group banner.
     */
    public function groupBanner()
    {
        return $this->belongsTo(Group::class, 'group_banner', 'id')->where('type', 'group_banner');
    }
}
