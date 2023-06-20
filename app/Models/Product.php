<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Database;

class Product extends Database { 
	protected $table = "product";	

	public function images(){
        return $this->hasMany('App\Models\Image');
    }
}
