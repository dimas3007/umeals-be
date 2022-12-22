<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Ingredient;
use App\Http\Resources\IngredientResource;

class MealIngredientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $ingredient = Ingredient::find($this->ingredient_id);
        return [
            'id' => $this->id,
            'meal_id' => $this->meal_id,
            'ingredient' => new IngredientResource($ingredient),
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
