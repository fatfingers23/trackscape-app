<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RunescapeUser
 * @package App\Models
 * @property $username
 * @property $admin
 * @property $activityHash
 * @property $clanId
 * @property $joinedDate
 * @property $rank
 * @property $discordId
 */
class RunescapeUser extends Model
{
    use HasFactory;

    protected $casts = [
        'admin' => 'boolean',
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
