<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'with', 'foto', 'description', 'tags', 'allergens', 'allergens_description', 'total_time', 'prep_time', 'difficulty', 'nutrition_value_id', 'price'];
}
