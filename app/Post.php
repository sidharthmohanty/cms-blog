<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;
use App\Tag;
use App\User;

class Post extends Model
{
    protected $dates = [
        'published_at'
    ];
    use SoftDeletes;
    protected $fillable =[
        'title',
        'content',
        'description',
        'image',
        'published_at',
        'category_id',
        'user_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function hasTag($id){
        return in_array($id, $this->tags->pluck('id')->toArray());
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function scopePublished($query){
        return $query->where('published_at', '<=', now());
    }

    public function scopeSearched($query){
        $search = request()->query('search');

        if(!$search){
            return $query->published();
        } else {
            return $query->published()->where('title', 'REGEXP', $search);

        }
    }
}
