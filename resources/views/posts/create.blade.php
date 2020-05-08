@extends ('layouts.app')

@section('content')
<div class="card card-default">
    <div class="card-header">
        {{isset($post)? 'Update Post' : 'Create Post'}}
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="list-group">
                    @foreach($errors->all() as $error)
                        <li class="list-group text-danger">{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if(isset($post))
            @method('PUT')
            @endif
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" value="{{isset($post) ? $post->title: ''}}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" value="{{isset($post)?$post->description:''}}">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <input id="content" type="hidden" name="content" value="{{isset($post) ? $post->content:''}}">
            <trix-editor input="content"></trix-editor>
        </div>
        <div class="form-group">
            <label for="published_at">Published at</label>
            <input type="text" class="form-control" name="published_at" id="published_at" placeholder="Enter date.." value="{{isset($post) ? $post->published_at : ''}}">
        </div>
        @if(isset($post))
            <div class="form-group">
                <img src="{{asset('storage/'.$post->image)}}" alt="" style="width:100%">        
            </div>
        @endif
        <div class="form-group">
            <label for="category">Select Category</label>
            <select class="form-control" name="category" id="category">
                @foreach($categories as $category)
                    <option value="{{$category->id}}" 
                        @if(isset($post))
                            @if($category->id == $post->category_id)
                                selected
                            @endif
                        @endif>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        @if($tags->count() > 0)
            <div class="form-group">
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags-selector" class="form-control" multiple="multiple">
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}"
                            @if(isset($post))
                                @if($post->hasTag($tag->id)))
                                    selected
                                @endif
                            @endif
                        >{{$tag->name}}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" name="image" value="{{isset($post)? $post->image: ''}}">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">{{isset($post)?'Update Post' : 'Add Post'}}</button>
        </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>

    flatpickr("#published_at", {
        enableTime: true,
        enableSecond: true
    })

   
</script>

<script>
     $(document).ready(function(){
        $('#tags-selector').select2();
    });
</script>

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
@endsection