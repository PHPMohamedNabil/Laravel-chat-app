<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="chat-list-header">
        <div class="title">
            Chat
        </div>
        <div class="chat-list-img-container">
             <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{auth()->user()->name}}" alt=""/>
        </div>
    </div>
        @if(count($conversations)>0)
         @foreach($conversations as $conversation)
           <div wire:key="{{$conversation->id}}" class="chat-list-body" wire:click="$emit('selectedChat',{{$conversation}},{{$this->setChatReciverInstance($conversation,$name='id')}})">
                  <div class="chat-list-item">
                      <div class="chat-list-img-container">
                        
                        <img src="https://ui-avatars.com/api/?background=eaeaea&color=2d2d2d&name={{$this->setChatReciverInstance($conversation,$name='name')}}" alt=""/>
                      </div>
                 </div>
             <div class="chatlist-info">
                 <div class="top-row">
                     <div class="list-username mb-3 ml-2">
                          {{$this->setChatReciverInstance($conversation,$name='name')}}
                     </div>
                     <span class="date"> {{$conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans()}}</span>

                 </div>
                 <div class="bottom-row">
                     <div class="messagebody text-truncate">
                         {{$conversation->messages->last()?->body}}
                     </div>
                   
                     @if( count($conversation->messages->where('seen',0)->where('receiver_id',auth()->user()->id)) !=0)
                           <div class="unread-count bg-danger text-white">
                             {{count($conversation->messages->where('seen',0)->where('receiver_id',auth()->user()->id))}}
                           </div>

                     @endif
                 </div>
             </div>
          </div>
        @endforeach   
       
        @else
         <center>no conversations founds</center>
        @endif
        

</div>
