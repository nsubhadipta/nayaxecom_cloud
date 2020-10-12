<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_dtl extends Model
{
    protected $table = 'order_dtl';
    protected $fillable = ['order_id','user_id', 'product_id','delivery_status'];
}
