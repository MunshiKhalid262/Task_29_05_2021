<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderdetails extends Model
{
   protected $table = 'orderdetails';
   
	public function orders()
	{
		return $this->belongsTo(Orders::class);
	} 
  	
}
