<?php

namespace App\Http\Controllers;

use App\{Category, Post, Tag};
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except([
            'index', 'show'
        ]);
    }

    public function index(){
        $posts = Post::latest()->paginate(6);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post){
        $posts = Post::where('category_id', $post->category_id)->latest()->limit(6)->get();
        return view('posts.show', compact('post', 'posts'));
    }

    public function create(){
        return view('posts.create', [
            'post' => new Post(),
            'categories' => Category::get(),
            'tags' => Tag::get(),
            ]);
    }

    public function store(PostRequest $request){
        // $post = new Post;
        // $post->title = $request->title;
        // $post->slug = \Str::slug($request->title);
        // $post->body = $request->body;
        // $post->save();

        // Post::create([
        //     'title' => $request->title,
        //     'slug' => \Str::slug($request->title),
        //     'body' => $request->body,
        // ]);

        $request->validate([
            'thumbnail' => 'image\mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        $attr = $request->all();
        $slug = \Str::slug(request('title'));
        $attr['slug'] = $slug;

        if (request()->file('thumbnail')){
            $thumbnail = request()->file('thumbnail');
            // $thumbnailUrl= $thumbnail->storeAs("images/posts", "{$slug}.{$thumbnail->extension()}");
            $thumbnailUrl = $thumbnail->store("images/posts");
            $attr['thumbnail'] = $thumbnailUrl;
        }

        // Assign title to the slug
        $attr['category_id'] = request('category');

        // Create new post
        $post = auth()->user()->posts()->create($attr);
        $post->tags()->attach(request('tags'));


        session()->flash('success', 'The post was created');

        return redirect()->to('posts');
        // return back();
    }

    public function edit(Post $post){
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get(),
        ]);
    }

    public function update(PostRequest $request, Post $post){
        $this->authorize('update', $post);





        $attr = $request->all();
        $slug = \Str::slug(request('title'));
        $attr['slug'] = $slug;

        if (request()->file('thumbnail')){
            \Storage::delete($post->thumbnail);
            $thumbnail = request()->file('thumbnail');
            // $thumbnailUrl= $thumbnail->storeAs("images/posts", "{$slug}.{$thumbnail->extension()}");
            $thumbnailUrl = $thumbnail->store("images/posts");
            $attr['thumbnail'] = $thumbnailUrl;
        }


        // Assign title to the slug
        $attr['category_id'] = request('category');

        $post->update($attr);
        $post->tags()->sync(request('tags'));

        session()->flash('success', 'The post was updated');
        return redirect('posts');
    }

    public function destroy(Post $post){
        if(auth()->user()->is($post->author)){
            \Storage::delete($post->thumbnail);
            $post->tags()->detach();
            $post->delete();
            session()->flash("success", "The post was destroyed");

            return redirect('posts');
        }
        else{
            session()->flash("error", "It wasn't your post");
            return redirect('posts');
        }

    }
}
