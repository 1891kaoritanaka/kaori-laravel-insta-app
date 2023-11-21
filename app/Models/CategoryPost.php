<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post';
    protected $fillable = ['category_id', 'post_id']; //we will use the createMany(method)//request array
    public $timestamps = false; //disable the automatic timestamps (created_at, updated_at)

    # Get the name of the category of the posts
    public function category(){
        return $this->belongsTo(Category::class); // Table: categories
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }
}
