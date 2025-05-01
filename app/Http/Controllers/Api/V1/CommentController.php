<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\Api\V1\StoreCommentRequest;
use App\Http\Resources\Api\V1\CommentResource;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        return CommentResource::collection(
            $post->comments()->with('user')->latest()->paginate(10)
        );
    }

    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return new CommentResource($comment->load('user'));
    }
}
