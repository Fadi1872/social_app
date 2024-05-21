<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $firstComment = $this->comments()->orderBy('created_at', 'desc')->first();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'category' => $this->category->name,
            'user_name' => $this->user->name,
            'comment' => $firstComment ? new CommentResource($firstComment) : null
        ];
    }
}
