<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'title' => '',
            'content' => ''
        ]);
        Post::create($data);
    }
}
