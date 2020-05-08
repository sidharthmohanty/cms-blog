@extends ('layouts.app')

@section('content')

<div class="d-flex justify-content-end mb-2">
    <a href="{{route('posts.create')}}" class="btn btn-success">Add Post</a>
</div>
<div class="card card-default">
    <div class="card-header">Posts</div>
    <div class="card-body">
        @if($posts->count() == 0)
            <h3 class="text-center">No Posts yet.. </h3>
        @else
            <table class="table">
                <thead>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{$post->title}}</td>
                            <td><img src="{{asset('storage/'.$post->image)}}" width="120px" height="60px" alt="{{$post->title}}"></td>
                            <td>
                                <a href="{{route('categories.edit', $post->category->id )}}">{{$post->category->name}}</a>
                            </td>
                            <td>
                                <a href="{{$post->trashed() ? route('trashed-post.restore', $post->id ) : route('posts.edit', $post->id)}}" class="btn btn-primary btn-sm float-right">{{$post->trashed() ? 'Restore' : 'Edit'}}</a>
                            </td>
                            <td>
                                <form action="{{route('posts.destroy',$post->id)}}" method="post" id="deletePost">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">{{$post->trashed() ? 'Delete': 'Trash'}}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection