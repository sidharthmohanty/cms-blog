<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Category;

class BlogController extends Controller
{
    public function show(Post $post)
    {
        return view('blog.show')
        ->with('post', $post);
    }

    public function tag(Tag $tag){
        return view('blog.tag')->with('tag', $tag)
        ->with('posts', $tag->posts()->searched()->simplePaginate(2))
        ->with('categories', Category::all())
        ->with('tags', Tag::all());
    }

    public function category(Category $category){
        return view('blog.category')->with('category', $category)
        ->with('posts', $category->posts()->searched()->simplePaginate(2))
        ->with('categories', Category::all())
        ->with('tags', Tag::all());
    }
}


