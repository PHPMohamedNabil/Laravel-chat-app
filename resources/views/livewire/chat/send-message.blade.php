<div>
    @if($selectedConversation)
         <form wire:submit.prevent="sendMessage" action="">
            <div class="chat-box-footer">
              <div class="custom-form-group">
                  <input wire:model="body" type="text" class="control" name="" placeholder="send message ...">
                  <button type="submit" class="submit">Send</button>
              </div>
            </div>
         </form>

    @endif

</div>
