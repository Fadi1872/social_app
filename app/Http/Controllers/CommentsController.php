<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(CommentResource::collection(Comment::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $comment = $request->validated();
        $comment['user_id'] = auth()->id();

        Comment::create($comment);

        return response()->json(['message' => 'comment added successfuly'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return response()->json(new CommentResource($comment), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return response()->json(['message' => 'comment updated successfuly'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if(in_array(auth()->id() ,[$comment->user_id, $comment->post->user_id])){
            $comment->delete();

            return response()->json(['message' => 'comment deleted successfuly'], 200);
        } else {
            return response()->json(['message' => "can't delete this comment"], 401);
        }
    }
}
