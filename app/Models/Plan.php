<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['preference', 'number_of_people', 'receipe_per_week',
     'price_per_servings', 'total_price', 'shipping', 'tax',
      'first_delivery_date', 'special_instructions', 'user_id', 'payment_method',
       'status', 'payment_status', 'address_id', 'discount'];
}
