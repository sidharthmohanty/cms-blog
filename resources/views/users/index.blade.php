@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-end mb-2">
    <a href="" class="btn btn-success">Add User</a>
</div>
<div class="card card-default">
    <div class="card-header">Users</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>Image</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if(!$user->isAdmin())
                            <form action="{{route('user-update', $user->id)}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Make Admin</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection