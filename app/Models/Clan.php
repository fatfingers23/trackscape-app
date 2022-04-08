<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Clan
 * @package App\Models
 * @property $name
 * @property $discordServerId
 * @property $confirmationCode
 * @property $discord_webhook
 * @property $save_chat_logs
 */
class Clan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'discord_server_id', 'confirmation_code'];

    public function members()
    {
        return $this->hasMany(RunescapeUser::class);
    }

    public function collectionLogLeaderBoard()
    {
        return $this->hasMany(CollectionLog::class)->with('player')->orderBy('collection_count', 'desc')->get();
    }

    public function bossPbLeaderBoard()
    {
        return $this->hasMany(CollectionLog::class)->with('player')->orderBy('kill_time', 'asc')->get();
    }
}
