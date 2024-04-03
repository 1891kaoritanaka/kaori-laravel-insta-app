<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    private $chat;
    private $user;

    public function __construct(Chat $chat, User $user){
        $this->chat = $chat;
        $this->user = $user;
    }

    public function index($id){
        $user = $this->user->findOrFail($id);
        $all_chats = $this->chat->latest()->get();
        return view('users.chats.index')->with('user',$user)->with('all_chats',$all_chats);
    }

    public function show($id){
        $user = $this->user->findOrFail($id);
        $all_chats = $this->chat->where('sender_id',$id)->latest()->get();
        return view('users.chats.chats')->with('user',$user)->with('all_chats',$all_chats);
    }
}
