<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required',
            'content' => ''
        ]);
        $post = Post::create($data);

        return redirect('/posts/' . $post->id);
    }

    public function update(Post $post, Request $request)
    {
        $data = $request->all();
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->save();
        return redirect('/posts/' . $post->id);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/posts/');
    }
}
