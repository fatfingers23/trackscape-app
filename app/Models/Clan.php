<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

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
    use HasFactory, Searchable;

    protected $fillable = ['name', 'discord_server_id', 'confirmation_code', 'wom_id'];

    public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
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

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize the data array...

        return $array;
    }

}
