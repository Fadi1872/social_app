<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = PostResource::collection(Post::all());

        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post = $request->validated();
        $post['user_id'] = auth()->id();

        Post::create($post);

        return response()->json(['message' => 'post added successfuly']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json(new PostResource($post));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return response()->json(['message' => 'post updated successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user->id == auth()->id()) {
            $post->delete();

            return response()->json(['message' => 'post deleted successfuly']);
        } else {
            return response()->json(['message' => "you can't delete other user's post"], 401);
        }
    }
    
    /**
     * get a post comments.
     */
    public function postComments(Post $post)
    {
        return response()->json(CommentResource::collection($post->comments), 200);
    }
}
