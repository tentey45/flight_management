<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * The roles that belong to the category.
     * * Many-to-Many Relationship with the Post model.
     */
    public function posts()
    {
        // The second argument specifies the exact name of the pivot table we created
        return $this->belongsToMany(Post::class, 'post_post_category');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}