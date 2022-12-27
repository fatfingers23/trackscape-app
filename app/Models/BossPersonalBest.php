<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BossPersonalBest
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $clan_id
 * @property int $bosses_id
 * @property int $runescape_users_id
 * @property int $kill_time
 * @property-read \App\Models\Boss|null $boss
 * @property-read \App\Models\RunescapeUser|null $player
 * @method static \Illuminate\Database\Eloquent\Builder|BossPersonalBest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BossPersonalBest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BossPersonalBest query()
 * @method static \Illuminate\Database\Eloquent\Builder|BossPersonalBest whereBossesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BossPersonalBest whereClanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BossPersonalBest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BossPersonalBest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BossPersonalBest whereKillTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BossPersonalBest whereRunescapeUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BossPersonalBest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BossPersonalBest extends Model
{
    use HasFactory;

    protected $guarded = [];

    
    public function player()
    {
        return $this->hasOne(RunescapeUser::class, 'id', 'runescape_users_id');
    }

    public function boss()
    {
        return $this->hasOne(Boss::class);
    }
}
