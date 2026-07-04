<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'body',
        'image',
    ];

    // A Post belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A Post has exactly one Meta record
    public function meta()
    {
        return $this->hasOne(PostMeta::class);
    }

    // A Post has many Comments
    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    // A Post belongs to many Categories
    public function categories()
    {
        // The second argument is the pivot table name if it doesn't follow Laravel's alphabetical convention
        return $this->belongsToMany(PostCategory::class, 'post_post_category'); 
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}