<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\CreateCategoryRequest;

class CategoriesController extends Controller
{
  
    public function index()
    {
        return view('categories.index')->with('categories', Category::all());
    }

 
    public function create()
    {
        return view('categories.create');
    }

  
    public function store(CreateCategoryRequest $request)
    {
       Category::create([
        'name' => $request->name
       ]);
        session()->flash('success', 'New category added successfully!!');
        return redirect(route('categories.index'));
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit(Category $category)
    {
        return view('categories.create')->with('category', $category);
    }

   
    public function update(CreateCategoryRequest $request, Category $category)
    {
        $category->update([
           'name' => $request->name
        ]);
        session()->flash('success', 'Category updated successfully');
        return redirect(route('categories.index'));
    }

   
    public function destroy(Category $category)
    {
        if($category->posts->count() > 0){
            session()->flash('error', 'Category is associated with posts..');
            return redirect()->back();
        }
        $category->delete();
        session()->flash('success', 'Category deleted successfully!!');
        return redirect(route('categories.index'));

    }
}
