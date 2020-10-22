<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $table = 'payment';
    protected $fillable = ['method','provider','payment_info','payment_status'];
    // public function Order()
    // {
    // 	return $this->belongsTo(Order::class);
    // }
    
}
