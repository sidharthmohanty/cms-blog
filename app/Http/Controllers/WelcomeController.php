<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
Use App\Post;
Use App\Tag;

class WelcomeController extends Controller
{
    public function index(){
        $data = request()->query('search');
        if($data){
            $posts = Post::where('title', 'REGEXP', $data)->simplePaginate(2);
        } else{
            $posts = Post::simplePaginate(2);
        }

        return view('welcome')
        ->with('categories', Category::all())
        ->with('tags', Tag::all())
        ->with('posts', Post::searched()->simplePaginate(2));
    }
}
