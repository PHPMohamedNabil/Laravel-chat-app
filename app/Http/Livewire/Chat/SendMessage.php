<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

class SendMessage extends Component
{   

   protected $listeners = ['updateSendMessage','dispatchMessageSent','resetComponent'];
   public    $selectedConversation;
   public    $receiverInstance;
   public    $created_message;
   public    $body;

    public function render()
    {
        return view('livewire.chat.send-message');
    }

    public function resetComponent()
    {
        $this->selectedConversation=null;
        $this->receiverInstance    =null;
    }

    public function updateSendMessage(Conversation $conversation,User $receiverInstance)
    {
        
        $this->selectedConversation = $conversation;

        $this->receiverInstance     = $receiverInstance;
    }

    public function sendMessage()
    {
          if($this->body =='')
          {
             return null;
          }

          $this->created_message = Message::create(['conversation_id'=>$this->selectedConversation->id,'sender_id'=>auth()->user()->id,'receiver_id'=>$this->receiverInstance->id,'body'=>$this->body]);

          $this->selectedConversation->last_time_message = $this->created_message->created_at;
          $this->selectedConversation->save();
          $this->emitTo('chat.chatbox','pushMessage',$this->created_message->id);
          $this->emitTo('chat.chat-list','refresh');
          $this->reset('body');
          $this->emitSelf('dispatchMessageSent');
    }

    public function dispatchMessageSent()
    {
        broadcast(new MessageSent(auth()->user(),$this->created_message,$this->selectedConversation, $this->receiverInstance));
    }
}
