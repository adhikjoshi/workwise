<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticalResource extends JsonResource
{

    // Article Resource to remove content from the list
    public function toArray($request)
    {
       return [
        'name' => $this->name,
        'author' => $this->author,
        'publication_date' => $this->publication_date,
       ];
    }
}
