<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
    
       $category = Category::all();
        $products = Product::all();
        return view('products.index',['products' => $products , 'category' =>$category]);
    }

    public function load_categories(){
        $categories = Category::where('status',1)->get();
       
        return response(['success' => true , 'data' => $categories]);
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
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'file|mimes:png,jpg,jpeg|dimensions:max_width=300,max_height=300',
            'price' =>'required|Numeric',
            'quantity' =>'required|Numeric',
        ]);
        $category = Category::where('name',$request->category)->first();
        $products = $category->products;
        foreach($products as $prod){
            if($prod->name == $request->name){
                return redirect()->back()->with("error","Product in this category already exist");
            }
        }
        if($request->file('image')){
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $destinationPath = public_path('uploads');
            $image->move($destinationPath, $image_name);
            $path = $image_name;
        }
        $data = $request->all();
        $data['path'] =$path;
        $product = Product::create($data);
        
        $product->category()->associate($category)->save();
        return redirect()->route('products.index')->with("success","Product Added Succefully");

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        $product['category_name'] =$product->category->name;
        return response(['success' => true , 'data' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $product['category_name']=$product->category->name;
        $categories=Category::where('name','<>',$product->category->name)->get();
        $product['categories']=$categories;
        return response(['success' => true , 'data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $request->validate([
            'edit_name' => 'required|string',
            'edit_price' =>'required|Numeric',
            'edit_quantity' =>'required|Numeric',
            'edit_image' =>'file|mimes:png,jpg,jpeg|dimensions:max_width=500,max_height=500',
        ]);
        $product = Product::find($id);
        $category = Category::where('name',$request->edit_category)->first();
        $products = $category->products;
        foreach($products as $prod){
            if($prod->name == $request->edit_name && $prod->name != $product->name){
                return response(['success' => false, 'error' => 'this product name already exists in this category']);
            }
        }
        
        if($request->file('edit_image')){
            if($product->path && file_exists(public_path('uploads/'.$product->path))){
                unlink(public_path('uploads/'.$product->path));
            }
            $image = $request->file('edit_image');
            $image_name = $image->getClientOriginalName();
            $destinationPath = public_path('uploads');
            $image->move($destinationPath, $image_name);
            $path = $image_name;
            $product['path'] =$path;
        }
        
        
        $product['name']=$request->edit_name;
        $product['description']=$request->edit_description;
        $product['price']=$request->edit_price;
        $product['quantity']=$request->edit_quantity;
        $product->category()->associate($category)->save();
        $product->save();
        return response(['success' => true, 'msg' => "Product updated successfully"]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if($product->path && file_exists(public_path('uploads/'.$product->path))){
            unlink(public_path('uploads/'.$product->path));
        }
        $product->delete();
        return response(["success" => true , "msg" => "Product deleted successfully"]);
    }

    // List delete products
    public function listDelete(Request $request){
        $products = Product::whereIn('id',$request->values)->get();
        foreach($products as $product){
            if($product->path && file_exists(public_path('uploads/'.$product->path))){
                unlink(public_path('uploads/'.$product->path));
            }
            $product->delete();
        }
        return response(['success' => true , 'msg' => "Product deleted successfully"]);
    }

    // Filter products
    public function Filter(Request $request){
        $category = $request -> values;
        $minPrice=$request ->minPrice;
        $maxPrice=$request ->maxPrice;

        if($category == null &&  $maxPrice == 0){
            
            return response(['success' => false]);
        }else if($category == null && $maxPrice != 0){
            $product = Product::whereBetween("price",[$minPrice,$maxPrice])->get();
            
        }else if($category != null && $maxPrice ==0){
            $product = Product::whereIn("category_id",$category)
            ->get();
        }else{
            $product = Product::whereIn("category_id",$category)
            ->whereBetween("price",[$minPrice,$maxPrice])
            ->get();
        }
        foreach($product as $prod){
            $prod['category_name']=$prod->category->name;
        }
        
        return response(['success' => true , 'data' => $product]);
    }
}
