<?php

namespace App\Http\Controllers;

use App\Model\Order;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('user.dashboard');
    }

    public function getOrder(Request $request){

        $user = $request->user();
        $orders = $user->orders;
        return view('user.order',['orders' => $orders]);
    }
}
