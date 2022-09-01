<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function getPost()
    {
        $posts = Post::latest()->get();

        return view('postlist', compact('posts'));
    }

    public function post(Request $request)
    {
        if ($request->ajax()) {

            $request->user()->posts()->create($request->all());

            return response($request->all());
        }
    }

    public function getComment(Request $request)
    {
        if ($request->ajax()) {
            $comments = $request->user()->comments()->where('post_id', $request->id)->latest()->paginate(3);

            return view('commentlist', compact('comments'));
        }
    }

    public function makeComment(Request $request)
    {
        if ($request->ajax()) {
            $request->user()->comments()->create($request->all());

            return response($request->all());
        }
    }
}
