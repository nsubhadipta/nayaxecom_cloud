<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'category';
    protected $fillable = ['name','description','thumbnail'];
    public function subCategory()
    {
    	return $this->hasMany(sub_category::class);
    }
}
