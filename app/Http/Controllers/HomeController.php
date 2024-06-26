<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(){
        $category = Category::all();
        $cat_pro=[];
        $pro = [];
        $i=0;
        foreach ($category as $cat)
        {
            foreach($cat -> products as $product){
                if($i=4){
                   break;
                }else{
                    array_push($pro,$product->path);
                    $i++;
                }
                
            }
            $cat_pro[$cat->name]=$pro;
            $pro=array();
        }
        
        return view('home',['category' => $category,'cat_pro' => $cat_pro]);
    }
}
