<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostController extends Controller
{
    public function show()
    {
        $post = new Post;
        $post->title = 'title1';
        $post->text = 'text1';
        $post->save();
    }
}
