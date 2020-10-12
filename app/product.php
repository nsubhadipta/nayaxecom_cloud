<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['sub_category_id','prod_name','prod_info','base_price','url','thumbnail'];
    // public function subCategory()
    // {
    // 	return $this->hasMany(sub_category::class);
    // }
    
}
