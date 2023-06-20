<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Database;

class Image extends Database { 
	protected $table = "image";	

	public function product(){
        return $this->belongsTo('App\Models\Product');
    }	

}
