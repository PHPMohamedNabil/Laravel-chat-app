<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;
use App\Models\User;

class Conversation extends Model
{
    use HasFactory;
    
    protected $fillable=[
            'sender_id',
            'recevier_id',
            'last_time_message'
    ];

    public function messages()
    {
       return $this->hasMany(Message::class);
    }

    public function user()
    {
       return $this->belongsTo(User::class);
    }
}
