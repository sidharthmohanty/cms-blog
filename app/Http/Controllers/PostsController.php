<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Post;
use App\Category;
use App\Tag;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostsController extends Controller
{
    public function __construct(){
        $this->middleware('VerifyCategoriesCount')->only(['create', 'store']);
    }


    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

   
    public function store(CreatePostRequest $request)
    {
        $image = $request->image->store('posts');

        $post = Post::create([
            'title' => $request->title,
            'category_id'=> $request->category,
            'description' => $request->description,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'image' => $image,
            'user_id' => auth()->user()->id
        ]);

        if($request->tags){
            $post->tags()->attach($request->tags);
        }

        session()->flash('success', 'New Post added successfully');
        return redirect(route('posts.index'));
    }

   
    public function show()
    {
        
    }

    public function edit(Post $post)
    {
        return view('posts.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
    }

    
    public function update(UpdatePostRequest $request, Post $post)
    {
        if($request->hasFile('image')){
            Storage::delete($post->image);
            $image = $request->image->store('posts');
            $post->update([
                'category_id' => $request->category,
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'published_at' => $request->published_at,
                'image' => $image
            ]);
        } else {
            $post->update([
                'category_id' => $request->category,
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'published_at' => $request->published_at,
            ]);
        }

        if($request->tags){
            $post->tags()->sync($request->tags);
        }
     
        session()->flash('success', 'Post updated successfully');
        return redirect(route('posts.index'));
    }
    
    public function destroy($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        if($post->trashed()){
            Storage::delete($post->image);
            $post->forceDelete();
            session()->flash('success', 'Post deleted successfully!!');
            return redirect(route('trashed-post.index'));

        } else {
            $post->delete();
        }
        session()->flash('success', 'Post trashed successfully!!');
        return redirect(route('posts.index'));
    }

    public function trashed(){
        $trashed = Post::onlyTrashed()->get(); 

        return view('posts.index')->with('posts', $trashed);
    }

    public function restore($id){
        Post::onlyTrashed()->findOrfail($id)->restore();
        session()->flash('success', 'Posts restored successfully');
        return redirect('/trashed');
    }
}