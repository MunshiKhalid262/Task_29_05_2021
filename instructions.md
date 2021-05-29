## Before you begin
This task is based on Laravel framework.

once you cloned this project, 


- prepare .env file
- run composer install
- create database called `backend-test`. and import `backend-test.sql`.
or just simply call `php artisan db:seed`. this will import required tables and data.

## Instructions
In this task, you will be creating an endpoint to fetch order details. 

You can use any architecture you prefer. We are looking for a smart solution/ architecture / pattern in your coding. 

We have done some stuffs to make things easier for you.( route and the controller is created for you.)

In `api.php` we have specified the route `/orders/{id}`. basically when someone try to get order details they should get order details as a json payload. we need exact data format with `200` status (check the format at the end of this documentation). if someone try to fetch an order which is not in the database, he should get `400` status code as response. 


### Database relationships

Here we have mentioned all the relationships you need.

<img src="https://www.mysqltutorial.org/wp-content/uploads/2009/12/MySQL-Sample-Database-Schema.png">



#### json payload for existing order number (/api/orders/10100)


    {
       "order_id":10100,
       "order_date":"2003-01-06",
       "status":"Shipped",
       "order_details":[
          {
             "product":"1917 Grand Touring Sedan",
             "product_line":"Vintage Cars",
             "unit_price":136,
             "qty":30,
             "line_total":"4080.00"
          },
          {
             "product":"1911 Ford Town Car",
             "product_line":"Vintage Cars",
             "unit_price":55.09,
             "qty":50,
             "line_total":"2754.50"
          },
          {
             "product":"1932 Alfa Romeo 8C2300 Spider Sport",
             "product_line":"Vintage Cars",
             "unit_price":75.46,
             "qty":22,
             "line_total":"1660.12"
          },
          {
             "product":"1936 Mercedes Benz 500k Roadster",
             "product_line":"Vintage Cars",
             "unit_price":35.29,
             "qty":49,
             "line_total":"1729.21"
          }
       ],
       "bill_amount":"10223.83",
       "customer":{
          "first_name":"Dorothy",
          "last_name":"Young",
          "phone":"6035558647",
          "country_code":"USA"
       }
    }

###Testing and Submission:
Some phpunit tests have been written so you can check your work. To run these `./vendor/bin/phpunit`. This is not mandatory but if you are good at testing feel free to run tests.   