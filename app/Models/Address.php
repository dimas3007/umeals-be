<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'street_address', 'apt_suite_floor', 'city', 'zip_code', "state", 
    "phone", "user_id"];
}
