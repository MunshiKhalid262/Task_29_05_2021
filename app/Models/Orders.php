<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
   protected $table = 'orders';	
   
	public function order_details()
	{
		return $this->hasOne('App\Models\Orders', 'orderNumber');
	}
}
