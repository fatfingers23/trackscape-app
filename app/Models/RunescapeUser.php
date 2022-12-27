<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RunescapeUser
 *
 * @package App\Models
 * @property $username
 * @property $admin
 * @property $activityHash
 * @property $clanId
 * @property $joinedDate
 * @property $rank
 * @property $discordId
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $activity_hash
 * @property int $clan_id
 * @property string|null $joined_date
 * @property string|null $discord_id
 * @property int|null $wom_id
 * @property \Illuminate\Support\Carbon|null $last_active
 * @method static \Database\Factories\RunescapeUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereActivityHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereClanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereDiscordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereJoinedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereLastActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RunescapeUser whereWomId($value)
 * @mixin \Eloquent
 */
class RunescapeUser extends Model
{
    use HasFactory;

    protected $casts = [
        'admin' => 'boolean',
        'last_active' => 'datetime:m-d-y'
    ];

    public function clanId()
    {
        return $this->hasOne(Clan::class);
    }

    protected $fillable = ['username', 'admin', 'activity_hash', 'clan_id', 'joined_date', 'rank', 'discord_id', 'wom_id'];

    public function getDonations()
    {
        $this->hasMany(Donation::class, 'runescape_username_id', 'id');
    }

}
