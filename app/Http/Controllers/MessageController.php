<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;
use App\Events\MessageSend;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user chat list.
     *
     * @return \Illuminate\Http\Response
     */
    public function userList()
    {
        $users = User::latest()->where('id', '!=', auth()->user()->id)->where('is_admin', '!=', 1)->get();
        // if not ajax request
        if(\Request::ajax()){
            return response()->json($users, 200);
        }
        return abort(404); 
    }

    /**
     * Display user message.
     *
     * @return \Illuminate\Http\Response
     */
    public function userMessage($id=null)
    {
        // if not ajax request
        if(!\Request::ajax()){
            return abort(404); 
        }
        // get single user
        $user = User::findOrFail($id);
        // get two users send and received message
        $messages = Message::where(function($q) use($id){
            $q->where('from', auth()->user()->id);
            $q->where('to', $id);
            $q->where('type', 0);
        })->orWhere(function($q) use($id){
            $q->where('from', $id);
            $q->where('to', auth()->user()->id);
            $q->where('type', 1);
        })->with('user')->get();

        return response()->json([
            'fetched_user' => $user,
            'fetched_messages' => $messages
            ]);
    }

    /**
     * Store user message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function messageSend(Request $request)
    {
        // store two users message
        $message = Message::create([
            'message' => $request->message,
            'from' => auth()->user()->id,
            'to' => $request->user_id,
            'type' => 0
        ]);
        $message = Message::create([
            'message' => $request->message,
            'from' => auth()->user()->id,
            'to' => $request->user_id,
            'type' => 1
        ]);

        // broadcast message
        broadcast(new MessageSend($message));
        return response()->json($message, 201);
    }
}
