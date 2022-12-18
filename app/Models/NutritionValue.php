<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionValue extends Model
{
    use HasFactory;

    protected $fillable = ['calories', 'saturated_fat', 'sugar', 'protein', 'sodium', 'fat', 'carbohidrates', 'dietary_fiber', 'colesterol'];
}
