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
            $messages = Message::where(function ($messages) use ($user_id){
                $messages->where('from',Auth::user()->id);
                $messages->where('to',$user_id);
            })->orWhere(function ($messages) use ($user_id){
                $messages->where('from',$user_id);
                $messages->where('to',Auth::user()->id);
            })->get();
            return $messages;
        }
        else{
            return Message::latest()->get();
        }

    }

    public function search()
    {

    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function restore()
    {

    }

    public function status()
    {

    }

}