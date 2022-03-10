<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentForm;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy("created_at", 'DESC')->paginate(3);
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Create comment to post
     *
     * @param $id
     * @param CommentForm $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function comment($id, CommentForm $request)
    {
        $post = Post::findOrFail($id);
        $comment = $post->comments()->create($request->validated());
        return response()->json(['text' => $comment->text, 'user_name' => $comment->user->name]);
    }
}
