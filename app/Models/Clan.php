<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * Class Clan
 *
 * @package App\Models
 * @property $name
 * @property $discordServerId
 * @property $confirmationCode
 * @property $discord_webhook
 * @property $save_chat_logs
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $discord_server_id
 * @property string $confirmation_code
 * @property string|null $wom_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RunescapeUser[] $members
 * @property-read int|null $members_count
 * @method static \Database\Factories\ClanFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Clan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Clan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Clan whereConfirmationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clan whereDiscordServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clan whereDiscordWebhook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clan whereSaveChatLogs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Clan whereWomId($value)
 * @mixin \Eloquent
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
