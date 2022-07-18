<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='food_item';
    protected $fillable =[
        'name ',
        'image',
        'base_price',
        'item_status',
        'is_drink',
        'is_hard_drink',
        'client_id',
        'category_id',
    ];

}
