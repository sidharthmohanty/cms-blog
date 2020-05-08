@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-end mb-2">
    <a href="{{route('tags.create')}}" class="btn btn-success">Add Tag</a>
</div>
<div class="card card-default">
    <div class="card-header">Tags</div>
    <div class="card-body">
        @if($tags->count() == 0)
            <h3 class="text-center">No Tags added yet..</h3>
        @else
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>No of Posts</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{$tag->name}}</td>
                            <td>{{$tag->posts->count()}}</td>
                            <td>
                                <a href="{{route('tags.edit', $tag->id)}}" class="btn btn-primary btn-sm float-right">Edit</a>
                            </td>
                            <td>
                                <form action="{{route('tags.destroy', $tag->id)}}" method="post"> 
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif    
    </div>
</div>
@endsection()