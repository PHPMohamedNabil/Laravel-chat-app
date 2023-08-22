<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
class CreateChat extends Component
{   
    public $users;

    

    public function render()
    {
        $this->users=User::where('id','!=',auth()->user()->id)->get();
         return view('livewire.chat.create-chat');
    }

    public function checkConversation($recevier_id)
    {
        $check = Conversation::where('recevier_id',auth()->user()->id)->where('sender_id',$recevier_id)->orWhere('recevier_id',$recevier_id)->where('sender_id',auth()->user()->id)->get();

        if(count($check)<1)
        {
            $create_conv = Conversation::create(['recevier_id'=>$recevier_id,'sender_id'=>auth()->user()->id,'last_time_message'=>0]); 
            $message     = Message::create(['conversation_id'=>$create_conv->id,'sender_id'=>auth()->user()->id,'receiver_id'=>$recevier_id,'body'=>'']); 

            $create_conv->last_time_message= $create_conv->created_at;
            $create_conv->save();

           // dd('saved');

        }


    }
}
