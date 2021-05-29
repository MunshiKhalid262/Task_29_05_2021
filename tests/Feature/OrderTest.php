<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{

    public function test_candidate_work()
    {
        for ($i = 10100; $i < 10110; $i++) {

            $response = $this->get('/api/orders/'.$i);
            $response->assertStatus(200)->assertExactJson(
                 $this->getStructure($i)
            );
        }
    }

    /**
     * A correct_order_id_will_return_json_payload.
     *
     * @return void
     */
    public function test_correct_order_id_will_return_json_payload()
    {
        $response = $this->get('/api/orders/10100');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "order_id",
            "order_date",
            "status",
            "order_details" => [
                [
                    "product",
                    "product_line",
                    "unit_price",
                    "qty",
                    "line_total",
                ]
            ],
            "bill_amount",
            "customer" => [
                "first_name",
                "last_name",
                "phone",
                "country_code",
            ]
        ]);

    }

    public function test_incorrect_order_id_will_return_json_payload()
    {
        $response = $this->get('/api/orders/10100000000');

        $response->assertStatus(400);
    }


    protected function getStructure($id)
    {
        $order = DB::table('orders')
            ->where('orders.orderNumber' ,(string)$id)
            ->get()->first();

        if (!$order) {
            return response('', '400');
        }

        $response = [];

        $response['order_id'] = $order->orderNumber;
        $response['order_date'] = $order->orderDate;
        $response['status'] = $order->status;

        $orderdetails = DB::table('orderdetails')
            ->where('orderNumber', $order->orderNumber)->get();
        $billTotal = 0;

        foreach ($orderdetails as $orderDetail) {

            $product = DB::table('products')->where('productCode', $orderDetail->productCode)->get()->first();

            $lineTotal = (float)$orderDetail->priceEach * $orderDetail->quantityOrdered;

            $response['order_details'][] = [
                'product' => $product->productName,
                'product_line' => $product->productLine,
                'unit_price' => (float)$orderDetail->priceEach,
                'qty' => $orderDetail->quantityOrdered,
                'line_total' => number_format($lineTotal, '2', '.', '')
            ];

            $billTotal += number_format($lineTotal, '2', '.', '');
        }

        $response['bill_amount'] = number_format($billTotal, '2', '.', '');

        $customer = DB::table('customers')->where('customerNumber', $order->customerNumber)->get()->first();

        $response['customer'] = [
            'first_name' => $customer->contactFirstName,
            'last_name' => $customer->contactLastName,
            'phone' => $customer->phone,
            'country_code' => $customer->country
        ];


        return $response;
    }
}
