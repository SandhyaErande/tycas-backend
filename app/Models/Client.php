<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='client';
    protected $fillable =[
        'restaurant_name ',
        'unique_code',
        'gst_number',
        'primary_contact_no',
        'secondary_contact_no',
        'address',
        'is_razorpay_allowed',
        'is_cred_allowed'
    ];
}
