<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Category;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::all();
        $category = Category::all();
        $products = [];
        foreach($data as $product) {
            if($product->category->status == 1){
                array_push($products, $product);
            }
        }
        return view('shop.index',['products' => $products ,'category' => $category]);
    }

    public function cart(Request $request){
        $prods_ids =explode(',',$request->products_ids);
        $request->session()->put('prods_ids', $prods_ids);
        return response(['success' => true]);
    }

    public function checkout(Request $request){
        if($request->session()->exists('prods_ids')){
            $prods_ids = $request->session()->get('prods_ids');
            
            $products = Product::whereIn('id', $prods_ids)->get();
            return view('shop.checkout', ['products' => $products]);
        }
    }

    public function pay(Request $request){
        
        $user = $request->user();

        $order = Order::create([
            "status" => 0
        ]);

            $products = array();
            for($i=0;$i< sizeof($request->name);$i++){
                //Cart creation
                $cart = Cart::create([
                'prod_name' => $request->name[$i],
                'quantity' => $request->quantity[$i],
                'price' => $request->price[$i]
                ]);
                $cart->order()->associate($order)->save();

                //checkout product creation
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
            $order->user()->associate($user)->save();
           
            $stripe = new \Stripe\StripeClient([
                "api_key" => env('STRIPE_SECRET')
              ]);
              $checkout_session = $stripe->checkout->sessions->create
                ([
    
                    'line_items' => [$products],
                    'mode' => 'payment',
                    'automatic_tax' => ['enabled' => true],
                    'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('shop'),
                    'metadata' => ['order_id' => $order->id],
                ]);
              
                return redirect()->away($checkout_session->url);
              
        
        
    }
    
    // If user stop the payment then comeback to pay later for the order
    public function pay_later(int $id){
        $order = Order::find($id);
        $products = array();
        foreach($order->carts as $cart){
            //checkout product creation
            array_push($products, [
                'price_data' => [
                'currency' => 'sar',
                'product_data' => [
                    'name' => $cart->prod_name,
                ],
                'unit_amount' => $cart->price*100,
                ],
                'quantity' => $cart->quantity,
            ]);
        }
        $stripe = new \Stripe\StripeClient([
            "api_key" => env('STRIPE_SECRET')
          ]);
          $checkout_session = $stripe->checkout->sessions->create
            ([

                'line_items' => [$products],
                'mode' => 'payment',
                'automatic_tax' => ['enabled' => true],
                'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('shop'),
                'metadata' => ['order_id' => $order->id],
            ]);
          
            return redirect()->away($checkout_session->url);

    }

    //  Checkout success
    public function checkout_success(Request $request){
        
        $sessionId = $request->get('session_id');

        if ($sessionId === null) {
            return redirect('/shop')->with("msg","No session id");
        }
       
        $stripe = new \Stripe\StripeClient([ "api_key" => env('STRIPE_SECRET')]);

        $session = $stripe->checkout->sessions->retrieve($sessionId);

        $orderId = $session['metadata']['order_id'] ?? null;
 
        $order = Order::findOrFail($orderId);
     
        $order->update(['status' =>1]);
        
        dd($order->carts()->get());
        
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
