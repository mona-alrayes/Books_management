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
            'title' => $this->title,
            'author' => $this->author,
            'published_at' => $this->published_at,
            'is_active' => $this->is_active == 0 ? 'نشط' : 'غير نشط',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
