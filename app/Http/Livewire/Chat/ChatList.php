<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

class ChatList extends Component
{  
    public $auth_id;
    public $conversations;
    public $receiverInstance;
    public $name;
    public $selectedConversation;
    protected $listeners = ['selectedChat','refresh'=>'$refresh','resetComponent'];

    public function render()
    {
        return view('livewire.chat.chat-list');
    }


    public function resetComponent()
    {
        $this->selectedConversation=null;
        $this->receiverInstance    =null;
    }

    public function  setChatReciverInstance(Conversation $conversation,$request)
    {
         $this->auth_id = auth()->user()->id;
         

         if($conversation->sender_id == $this->auth_id)
         {
           $this->receiverInstance  = User::firstWhere('id',$conversation->recevier_id);

         }
         else
         {
            $this->receiverInstance = User::firstWhere('id',$conversation->sender_id);
         }

         if(isset($request))
         {
             return $this->receiverInstance->$request;
         }
    }

    public function selectedChat(Conversation $conversation,$recevier_id)
    {
     //   dd($conversation,$recevier_id);
         $this->selectedConversation =$conversation;

         $recevier_id = User::find($recevier_id);
       $this->emitTo('chat.chatbox','loadConversation',$this->selectedConversation,$recevier_id );
        $this->emitTo('chat.send-message','updateSendMessage',$this->selectedConversation,$recevier_id);
    }

    public function mount()
    {
        $this->auth_id       = auth()->user()->id;
        $this->conversations = Conversation::where('sender_id',$this->auth_id)->orWhere('recevier_id',$this->auth_id)->orderBy('last_time_message','DESC')->get();

        

    }
}
