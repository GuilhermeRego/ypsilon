<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    // Table that this model refers to.
    protected $table = 'report';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reporter_user_id',
        'reported_user_id',
        'reported_post_id',
        'reported_comment_id',
        'reported_group_id',
        'justification',
        'date_time'    
    ];

    protected $primaryKey = 'id';

    // Eloquent relationship between User Repoorter and Report.
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_user_id');
    }

    // Eloquent relationship between User Repoorted and Report.
    public function reported_user()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    // Eloquent relationship between Post and Report.
    public function post()
    {
        return $this->belongsTo(Post::class, 'reported_post_id', 'id');
    }

    // Eloquent relationship between Report and Report_Comment.
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'reported_comment_id', 'id');
    }

    // Eloquent relationship between Report and Group.
    public function group()
    {
        return $this->belongsTo(Group::class, 'reported_group_id', 'id');
    }
}