<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'cover' => asset('storage/' . $this->cover),
            'category' => CategoryResource::make($this->category),
            'author' => AuthorResource::make($this->author),
            'publisher' => PublisherResource::make($this->publisher),
            'isbn' => $this->isbn,
            'publication_year' => $this->publication_year,
            'stock' => $this->stock,
        ];
    }
}
