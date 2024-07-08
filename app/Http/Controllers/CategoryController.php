<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        if(!gate::allows('view-dashboard')){
            abort(403);
        }
    }
    
    public function index()
    {
        $categories = Category::all();
        return view('category.index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            
        ]);
        $categories = Category::All();
        foreach($categories as $category){
            if($category->name == $request->name){
                return redirect()->route('category.index')->with('error','"'.$request->name.'" this category name already exist');
            }
        }
        if(!isset($request->status)){
            $request['status']=0;
        }
        $data = $request->all();
        $category = Category::create($data);
        return redirect()->route('category.index')->with("success","Added Succefully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        return response(['success' => true , 'data' => $category]);
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
        
        $request->validate([
            'name' => 'required',
            
        ]);
        $cat = Category::find($id);
        $categories = Category::where('name', '<>', $cat->name)->get();
        foreach($categories as $category){
            if($category->name == $request->name){
                return response(['success' => false, 'error' => "name already exists"]);
            }
        }

        $cat['name'] = $request->name;
        $cat['status'] = $request->status;
        $cat->save();
        return response(['success' => true, 'msg' => "Category updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $products = $category->products;
       // delete complete
       if(!$products->isEmpty()){
        $cat = Category::where("name","uncategorized")->first();
        foreach($products as $product){
            $product->category()->associate($cat)->save();
            $product->save();
        }
       }
        $category->delete();
        return response(["success" => true , "msg" => "category deleted successfully"]);
    }

    public function category_has_products(string $id){
        $category = Category::find($id);
        $products = $category->products;
        if($products->isEmpty()){
            return response(['success' => false]);
        }
        return response(['success' => true, 'msg' => "this category has products"]);
    }
}
