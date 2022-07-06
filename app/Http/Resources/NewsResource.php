<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'author name' => $this->author_name,
            'title' => $this->title,
            'link' => $this->link,
            'upvotes' => $this->upvotes,
            'comments' => CommentResource::collection($this->comments)
        ];
    }
}
