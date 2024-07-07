<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
 
    public function pay(Request $request){
        $products = array();
        for($i=0;$i< sizeof($request->name);$i++){
            
            array_push($products, [
                'price_data' => [
                'currency' => 'sar',
                'product_data' => [
                    'name' => $request->name[$i],
                ],
                'unit_amount' => $request->price[$i]*100,
                ],
                'quantity' => $request->quantity[$i],
            ]);
        }
       
        $stripe = new \Stripe\StripeClient([
            "api_key" => env('STRIPE_SECRET')
          ]);
          $checkout_session = $stripe->checkout->sessions->create
            ([

                'line_items' => [$products],
                'mode' => 'payment',
                'success_url' => route('shop'),
                'cancel_url' => route('shop'),
            ]);
            
            return redirect()->away($checkout_session->url);
          
    }

   
}
