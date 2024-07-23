<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message;

class ChatsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message=Message::with('user')->get();
        return view('chat',['message'=>$message]);
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
    $user = Auth::user();
    $message=array();
    $message['user_id']=$user->id;
    $message['message'] = $request->message;
    
    $id = Message::create($message);
    $id->User()->associate($user)->save();
    MessageSent::dispatch($user,$id);
    return response()->json(['status' => 'Message Sent!']);
}

}


