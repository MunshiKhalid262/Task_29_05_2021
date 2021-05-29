<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
//use App\Models\Orders;
//use App\Models\Orderdetails;


class OrdersController extends Controller
{

    /**
     * fetch order details
     * @param $id
     * @return array
     */
    public function fetchOrderData($id)
    {
	   $line_total = 0;
	   $data = [];
	   $orders_table = DB::table('orders')->select('orderNumber','orderDate','status','customerNumber')->where('orderNumber',$id);
	   if($orders_table->count()>0){
		   $orders = $orders_table->first();
		   $orderdetails = DB::table('orderdetails')
		   ->join('products','orderdetails.productCode','=','products.productCode')
		   ->select('products.productName as product','products.productLine as product_line','orderdetails.priceEach as unit_price','orderdetails.quantityOrdered as qty',DB::raw('orderdetails.quantityOrdered*orderdetails.priceEach AS line_total'))
		   ->where('orderdetails.orderNumber',$id)->get();
		   foreach($orderdetails as $orderdetail){
			   $line_total += $orderdetail->line_total;
		   }

		   $cid = $orders->customerNumber;
		   $customers = DB::table('customers')->select('contactFirstName as first_name','contactLastName as last_name','phone','postalCode as country_code')->where('customerNumber',$cid)->first();
		   
		   
		   
		   $data['order_id'] = $orders->orderNumber;
		   $data['order_date'] = $orders->orderDate;
		   $data['status'] = $orders->status;
		   $data['order_details'] = $orderdetails;
		   $data['line_total'] = round($line_total,2);
		   $data['customers'] = $customers;
	   }else{
			$data['status'] = 400;
	   }
	   
	   return response()->json($data);
    }
}
