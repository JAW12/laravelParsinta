@extends('layouts.app')
@section('content')
<div class="">
    <div>
        @isset($category)
        <h4>Category: {{$category->name}}</h4>
        @endisset

        @isset($tag)
        <h4>Tag: {{$tag->name}}</h4>
        @endisset

        @if(!isset($tag) && !isset($category))
        <h4>All Post</h4>
        @endif
    </div>
    {{-- <div>
        @if(Auth::check())
            <a href="{{ route('posts.create') }}" class="btn btn-primary">New post</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Login to create new post</a>
        @endif
    </div> --}}
</div>
<div class="row">
    <div class="col-md-6">
        @forelse($posts as $post)
        <div class="card mb-4">
            @if($post->thumbnail)
                <a href="{{ route('posts.show', $post->slug)}}">
                <img style="height: 400px; object-fit: cover; object-position: center;" src="{{ $post->takeImage }}" alt="" class="card-img-top">
                </a>
            @endif
            <div class="card-body">
                <div>
                    <a href="{{ route('categories.show', $post->category->slug) }}" class="text-secondary small">
                        {{$post->category->name}}
                    </a>
                    -
                    @foreach($post->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="text-secondary small">
                            {{$tag->name}}
                        </a>
                    @endforeach
                </div>

                <h5>
                    <a href="{{ route('posts.show', $post->slug)}}" class="card-title text-dark">
                        {{$post->title}}
                    </a>
                </h5>

                <div class="text-secondary my-3">
                    {{ Str::limit($post->body, 130, ".") }}
                </div>
                {{-- <div>
                    <a href="/posts/{{$post->slug}}">Read more</a>
                </div> --}}
                <div class="d-flex justify-content-between align-items-center">
                    <div class="media align-items-center mt-2">
                        <img width="40" class="rounded-circle mr-3" src="{{ $post->author->gravatar()}}">
                        <div class="media-body">
                            <div>
                                {{$post->author->name}}
                            </div>
                        </div>
                    </div>

                    <div class="text-secondary small mt-2">
                        Published on {{$post->created_at->diffForHumans()}}
                    </div>
                </div>

            </div>
        </div>
        @empty
            <div class="col-md-6">
                <div class="alert alert-info">
                    There are no posts.
                </div>
            </div>
        @endforelse
    </div>
</div>


<div class="d-flex justify-content-center">
    <div>
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
</div>
@stop
