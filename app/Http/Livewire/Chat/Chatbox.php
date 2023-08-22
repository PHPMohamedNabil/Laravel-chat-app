<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use App\Events\MessageSeen;

class Chatbox extends Component
{   
    //protected $listeners = ['loadConversation','pushMessage','loadmore','updateHeight'];
    public    $selectedConversation;
    public    $receiverInstance;
    public    $paginate_msg = 10;
    public    $messages;
    public    $height;
    
    public function render()
    {
        return view('livewire.chat.chatbox');
    }


    public function getListeners()
    {   
        $auth_id = auth()->user()->id; 
        return [
           "echo-private:chat.{$auth_id},MessageSent"=>'broadcastedMessageReceived',
           'loadConversation','pushMessage','loadmore','updateHeight',
          "echo-private:chat.{$auth_id},MessageSeen"=>'broadcastedMessageSeen','broadcastMessageRead','resetComponent'
        ];
    }


    public function resetComponent()
    {
        $this->selectedConversation=null;
        $this->receiverInstance    =null;
    }

    public function broadcastedMessageSeen($event)
    {
        if($this->selectedConversation && $this->selectedConversation->id == $event['conversation_id'])
        {
               $this->dispatchBrowserEvent('markMessageAsSeen');
             
        }
    }

     public function broadcastMessageRead()
    {
       broadcast(new MessageSeen($this->selectedConversation->id,$this->receiverInstance->id));
    }

    public function broadcastedMessageReceived($event)
    {
        $this->emitTo('chat.chat-list','refresh');
       $broadcastedMessage = Message::find($event['message']);
      
       if($this->selectedConversation && $this->selectedConversation->id ==$event['conversation_id'])
       {   

            $broadcastedMessage->seen=1;
            $broadcastedMessage->save();

            $this->pushMessage($broadcastedMessage->id);

            $this->emitSelf('broadcastMessageRead');
          
       }
    }

    public function loadConversation(Conversation $conversation,User $receiverInstance)
    {
         $this->selectedConversation = $conversation;
         $this->receiverInstance     = $receiverInstance;

          $this->messages_count = Message::where('conversation_id',$this->selectedConversation->id)->count();

          $this->messages       = Message::where('conversation_id',$this->selectedConversation->id)->skip($this->messages_count - $this->paginate_msg)->take($this->paginate_msg)->get();

          $this->dispatchBrowserEvent('chatSelected');

          Message::where('conversation_id',$this->selectedConversation->id)->where('receiver_id',auth()->user()->id)->update(['seen'=>1]);
          $this->emitSelf('broadcastMessageRead');
          $this->emitTo('chat.chat-list','refresh');

    }

    public function pushMessage($message_id)
    {
         $new_message = Message::find($message_id);

         $this->messages->push($new_message);

         $this->dispatchBrowserEvent('rowChatToBottom');
    }

    public function loadmore()
    {
         $this->paginate_msg=$this->paginate_msg+10;

         $this->messages_count = Message::where('conversation_id',$this->selectedConversation->id)->count();

         $this->messages       = Message::where('conversation_id',$this->selectedConversation->id)->skip($this->messages_count - $this->paginate_msg)->take($this->paginate_msg)->get();
          $height=$this->height;
         $this->dispatchBrowserEvent('updatedHeight', ($height));
    }

    public function updateHeight($height)
    {
        $this->height = $height;


    }

}
