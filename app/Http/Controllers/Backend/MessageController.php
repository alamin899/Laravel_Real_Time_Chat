<?php

namespace App\Http\Controllers\Backend;

use App\Events\MessageSend;
use App\Http\Controllers\Controller;
use App\Message;
use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct(MessageRepository $messageRepository,UserRepository $userRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id ='',Request $request)
    {
        if(!$request->ajax())
        {
            abort("404","message not found");
        }
        return response()->json([
            'message'=> $this->messageRepository->index($user_id),
            'user' => $this->userRepository->index($user_id)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $types=[0,1];
        foreach ($types as $type){
            $req = new Request([
                'from' => Auth::user()->id,
                'to' => $request->receiver_id,
                'message' =>$request->message,
                'type' => $type,
            ]);
            $sendMessage= $this->messageRepository->store($req);
            broadcast(new MessageSend($sendMessage));
        }
        return response()->json($sendMessage,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function singleMessageDestroy($message_id)
    {
        if (!\Request::ajax()){
            abort('404');
        }
        return $this->messageRepository->singleMessageDestroy($message_id);
    }
    public function allMessageDestroy($user_id)
    {
        if (!\Request::ajax()){
            abort('404');
        }
        return $this->messageRepository->allMessageDestroy($user_id);
    }
}
