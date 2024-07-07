<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        $fproducts=Product::all()->take(4);
        $category = Category::all()->take(3);
        $cat_pro=[];
        $pro = [];
        foreach ($category as $cat)
        {
            $products = $cat->products;
            if(count($products)>=2){
                for($i=0;$i<2;$i++){
                    array_push($pro,$products[$i]->path);
                }
                $cat_pro[$cat->name]=$pro;
                $pro=array();
            } 
        }
       
        return view('home',['cat_pro' => $cat_pro,'fproducts'=>$fproducts]);
    }
}
