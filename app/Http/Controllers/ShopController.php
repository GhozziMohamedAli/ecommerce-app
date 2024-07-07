<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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
