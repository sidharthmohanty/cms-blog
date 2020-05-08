<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Http\Requests\Tag\CreateTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;


class TagsController extends Controller
{
    public function index()
    {
        return view('tags.index')->with('tags', Tag::all());
    }
  
    public function create()
    {
        return view('tags.create');
    }
  
    public function store(CreateTagRequest $request)
    {
        Tag::create([
            'name' => $request->name
        ]);

        return redirect(route('tags.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Tag $tag)
    {

        return view('tags.create')->with('tag', $tag);
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update([
            'name' => $request->name
        ]);
        session()->flash('success', 'Tag has been updated successfully');
        return redirect(route('tags.index'));
    }

    public function destroy(Tag $tag)
    {
        if($tag->posts()->count() > 0){
            session()->flash('error', 'Tag is associated with other post..');
            return redirect()->back();
        }
        $tag->delete();
        session()->flash('success', 'Tag has been deleted successfully');
        return redirect(route('tags.index'));
    }
}