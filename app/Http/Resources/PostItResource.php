<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostItResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'color'       => $this->color,
            'font_family' => $this->font_family,
            'font_size'   => $this->font_size,
            'size'        => $this->size,
            'created_at'  => $this->created_at->toDateTimeString(),
            'user'        => [ 'id'=>$this->user->id, 'name'=>$this->user->name ],
        ];
    }
}
