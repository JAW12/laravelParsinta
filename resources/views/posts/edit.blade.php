@extends('layouts.app', ['title' => "Update post"])
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Update Post : {{$post->title}}</div>
                <div class="card-body">
                    <form action="/posts/{{$post->slug}}/edit" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        @include('posts.partials.form-control')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
