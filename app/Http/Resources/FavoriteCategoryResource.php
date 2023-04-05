<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'category' => $this->category,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
        ];
    }
}
