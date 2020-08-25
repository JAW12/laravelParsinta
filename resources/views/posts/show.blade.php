@extends('layouts.app')
@section('title', $post->title)
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @if($post->thumbnail)
                <img src="{{ $post->takeImage }}" alt="" class="rounded w-100" style="height: 550px; object-fit: cover; object-position: top;">
            @endif

            <h1>{{ $post->title }}</h1>
            <div class="text-secondary mb-3">
                <a href="/categories/{{$post->category->slug}}">{{ $post->category->name }}</a> &middot; {{ $post->created_at->format('d F, Y') }}
                &middot;
                @foreach($post->tags as $tag)
                    <a href="/tags/{{$tag->slug}}">{{$tag->name}}</a>
                @endforeach

                <div class="media my-3">
                    <img width="60" class="rounded-circle mr-3" src="{{ $post->author->gravatar()}}">
                    <div class="media-body">
                        <div>
                            {{$post->author->name}}
                        </div>
                        <div>
                            {{'@' . $post->author->username}}
                        </div>
                    </div>
                </div>
            </div>
            <p>{!! nl2br($post->body) !!}</p>
            <div>
                @if(auth()->user()->is($post->author))
                <!-- Button trigger modal -->
                <div class="d-flex mt-3">
                    <div>
                        <a href="/posts/{{$post->slug}}/edit" class="btn btn-success btn-sm">Edit</a>
                    </div>

                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">
                        Delete
                    </button>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin menghapusnya?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <div>{{$post->title}}</div>
                                    <div class="text-secondary small">
                                        Published: {{$post->created_at->format("d F, Y")}}
                                    </div>
                                </div>
                                <form action="/posts/{{$post->slug}}/delete" method="post">
                                    @csrf
                                    @method("delete")
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-danger mr-2">
                                            Ya
                                        </button>
                                        <button type="button" class="btn btn-success" data-dismiss="modal">Tidak</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            @foreach($posts as $post)
            <div class="card mb-4">
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
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
