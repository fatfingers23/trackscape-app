<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A model that holds a chat log from in game
 *
 * @property $time_sent
 * @property $sender
 * @property $message
 * @property $clan_id
 * @property $chat_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Clan|null $clan
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog whereClanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog whereTimeSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChatLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'time_sent' => 'datetime:d/m H:i:s',
    ];

    public function clan()
    {
        return $this->hasOne(Clan::class);
    }

}
