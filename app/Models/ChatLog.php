<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A model that holds a chat log from in game
 * @property $time_sent
 * @property $sender
 * @property $message
 * @property $clan_id
 * @property $chat_id
 */
class ChatLog extends Model
{
    use HasFactory;

    protected $casts = [
        'time_sent' => 'datetime:d/m H:i:s',
    ];

    public function clan()
    {
        return $this->hasOne(Clan::class);
    }

}
