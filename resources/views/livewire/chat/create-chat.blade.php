<div>

    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <ul class="list-group w-75 mx-auto mt-3 container-fluid">
      @foreach($users as $user)
        <li class="list-group-item list-group-item-action mb-4" wire:click="checkConversation({{$user->id}})">{{$user->name}}</li>
      @endforeach
    </ul>
</div>
