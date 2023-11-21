@extends('layouts.app')

@section('title','Post Category Show')

@section('content')
    <div class="row gx-5">
        <div class="col-8">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $category->categoryPost as $category_post)
                        <tr>
                            <td>{{ $category_post->post_id }}</td>
                            <td>
                                <a href="{{ route('post.show',$category_post->post_id) }}">
                                    <img src="{{ $category_post->post->image }}" alt="{{ $category_post->post->id }}" class="image-lg">
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-50">{{ $category->name }}</span>
                            </td>
                            <td>{{ $category_post->post->user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col mt-5">
            <div class="card bg-white border-0 shadow">
                <div class="card-body">
                    <h4>Total post for category : {{ $category->name }}</h4>
                    <h4 class="fw-bold">Total : {{ $category->categoryPost->count() }}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
