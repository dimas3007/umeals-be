<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealIngredientNotIncluded extends Model
{
    use HasFactory;
    
    protected $fillable = ['meal_id', 'ingredient', 'amount', 'unit', 'contains', 'foto'];
}
