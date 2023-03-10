<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'meal_id', 'amount', 'status', 'total_price', 'payment_method', 'special_instructions', 'delivery_date', 'discount', 'tax', 'shipping', 'address_id', 'payment_status', 'total_price_product', 'uuid'];
}
