<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sub_category extends Model
{
    protected $table = 'sub_category';
    protected $fillable = ['category_id','name','description','thumbnail'];
    // public function products()
    // {
    // 	return $this->belongsTo(product::class);
    // }
    public function category()
    {
    	return $this->belongsTo(category::class);
    }
}
