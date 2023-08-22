<div>
    @if($selectedConversation)
         <div class="chat-box-header">
        <div class="return">
            <i class="bi bi-arrow-left arrow-mob"></i>
        </div>
         <div class="chat-list-img-container">
                <img src="https://ui-avatars.com/api/?background=eaeaea&color=2d2d2d&name={{$receiverInstance->name}}" alt=""/>
         </div>
         <div class="name">
             {{$receiverInstance->name}}
         </div>
         <div class="info">
              <div class="info-item">
                <i class="bi bi-image"></i>
             </div>
              <div class="info-item">
                 <i class="bi bi-info-circle-fill"></i>
             </div>
         </div>
    </div>
    <div class="chat-box-body" >
        @foreach($messages as $message)
            @if(mb_strlen($message->body))
              <div class="chat-msg-body {{auth()->user()->id == $message->sender_id?'chat-msg-body-me':'chat-msg-body-recevier' }}" style="width:80%;max-width:80%;max-width:max-content;">
                   {{$message->body}}
                  <div class="chat-msg-body-footer">
                      <div class="date">
                          {{$message->created_at->format('m: i a')}}
                      </div>
                      <div class="read">
                          @if($message->user->id == auth()->user()->id)
                               @if($message->seen ===0)
                                    <i class="bi bi-check2 status_tick"></i>
                               @else 
                                    <i class="bi bi-check2-all text-primary "></i>
                               @endif


                          @endif
                      </div>
                  </div>    
              </div>   
                    
            @endif   

        @endforeach
     

    </div>
     <script type="text/javascript">
          $('.chat-box-body').scroll(function(){
             let top = $('.chat-box-body').scrollTop();
             if(top ==0)
             {
                 window.livewire.emit('loadmore');
             }
         });
        
     </script>
     <script type="text/javascript">
         window.addEventListener('updatedHeight',e=>{
             let old = e.detail.height;
             let newHeight = $('.chat-box-body')[0].scrollHeight;  

             let height     = $('.chat-box-body').scrollTop(newHeight-old);

             window.livewire.emit('updateHeight',{height:height});
         });
     </script>
    @else
         <center class="text-primary mt-5">start conversation by clicking one from left side menu...</center>
   
    @endif
   
 <script type="text/javascript">
    window.addEventListener('rowChatToBottom',e=>{
       

         $('.chat-box-body').scrollTop($('.chat-box-body')[0].scrollHeight);




    });

    
 </script>

 <script type="text/javascript">
     $(document).on('click','.return',function(){
          window.livewire.emit('resetComponent');
     });
 </script>

 <script type="text/javascript">
     window.addEventListener('markMessageAsSeen',function(e){
           
           let value = document.querySelectorAll('.status_tick');

           value.forEach((item, index)=>{

                elm.classList.remove('bi bi-check2');
                elm.classList.add('bi bi-check2-all','text-primary');
           });

     });
 </script>
</div>
