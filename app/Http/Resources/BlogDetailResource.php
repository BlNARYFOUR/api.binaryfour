<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'location' => $this->location,
            'duration' => $this->duration,
            'title' => $this->title,
            'body' => $this->body,
            'goal_audience' => $this->goal_audience,
            'user_name' => $this->user ? $this->user->name : null,
            'tag' => $this->tag ? $this->tag->name : null,
        ];
    }
}
