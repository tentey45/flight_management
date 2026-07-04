<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostMeta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'seo_title',
        'keywords',
    ];

    /**
     * Get the post that owns the meta data.
     * * Inverse of the One-to-One Relationship.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}