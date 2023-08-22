<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="chat">
        <div class="chat-list-container">
            @livewire('chat.chat-list')
        </div>
        <div class="chat-box-container">
            @livewire('chat.chatbox')

            @livewire('chat.send-message')

        </div>
    </div>
    <script type="text/javascript">

        window.addEventListener('chatSelected',e=>{
             if(window.innerWidth <768)
             {
                  $('.chat-list-container').hide();
                  $('.chat-box-container').show();
             }

             $('.chat-box-body').scrollTop($('.chat-box-body')[0].scrollHeight);
             let height = $('.chat-box-body')[0].scrollHeight;

             window.livewire.emit('updateHeight',{height:height});
        });

        $(window).resize(function(){
             if(window.innerWidth >768)
             {
                  $('.chat-list-container').show();
                  $('.chat-box-container').show();
             }
        });
       


        $(document).on('click','.return',function(){
                 $('.chat-list-container').show();
                  $('.chat-box-container').hide();     
        });
    </script>
</div>
