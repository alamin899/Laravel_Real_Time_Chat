<?php
/**
 * Created by PhpStorm.
 * User: alamin899
 * Date: 9/11/2020
 * Time: 12:08 PM
 */

namespace App\Repositories;


use App\Message;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    public function index($user_id='')
    {
        if ($user_id !=''){
            return $this->getMessageById($user_id);
        }
        else{
            return Message::latest()->get();
        }

    }

    public function search()
    {

    }

    public function store($request)
    {
        $store = Message::create([
            'from' => $request->from,
            'to' => $request->to,
            'message' => $request->message,
            'type' => $request->type,
        ]);
        return $store;

    }

    public function update()
    {

    }

    public function singleMessageDestroy($message_id)
    {
        return Message::find($message_id)->delete();
    }
    public function allMessageDestroy($user_id)
    {
        $messages = $this->getMessageById($user_id);
        foreach ($messages as $message){
            Message::find($message->id)->delete();
        }
        return response()->json("all message deleted",200);
    }

    protected function getMessageById($user_id){
        $messages = Message::where(function ($messages) use ($user_id){
            $messages->where('from',Auth::user()->id);
            $messages->where('to',$user_id);
            $messages->where('type',0);
        })->orWhere(function ($messages) use ($user_id){
            $messages->where('from',$user_id);
            $messages->where('to',Auth::user()->id);
            $messages->where('type',1);
        })->get();
        return $messages;
    }

}