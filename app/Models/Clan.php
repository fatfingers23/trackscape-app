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
 */
class Clan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'discord_server_id', 'confirmation_code'];

}
