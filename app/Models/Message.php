<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Conversation;
class Message extends Model
{
    use HasFactory;

    protected $fillable=[
         'sender_id',
         'conversation_id',
         'receiver_id',
         'seen',
         'type',
         'body'
      ];


      public function conversation()
      {
           return $this->belongsTo(Conversation::class);
      }


      public function user()
      {
           return $this->belongsTo(User::class,'sender_id');
      }
}
