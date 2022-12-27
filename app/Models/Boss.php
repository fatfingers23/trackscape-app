<?php

namespace App\Models;

use App\Jobs\PersonalBestJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Boss
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BossPersonalBest[] $Pbs
 * @property-read int|null $pbs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BossPersonalBest[] $bossPersonalBest
 * @property-read int|null $boss_personal_best_count
 * @method static \Illuminate\Database\Eloquent\Builder|Boss newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Boss newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Boss query()
 * @method static \Illuminate\Database\Eloquent\Builder|Boss whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boss whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boss whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Boss whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Boss extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['name'];

    public function Pbs()
    {
        return $this->hasMany(BossPersonalBest::class, 'bosses_id');
    }

    public function bossPbLeaderBoardByClan(int $clanId)
    {
        return $this->hasMany(BossPersonalBest::class)->with('player')->
        where('clan_id', $clanId)->orderBy('kill_time', 'asc')->get();
    }

    public function bossPersonalBest()
    {
        return $this->hasMany(BossPersonalBest::class)->with('player');
    }


    public static function stop5BossPbLeaderBoardByClan(int $clanId)
    {
        return Boss::with('bossPersonalBest')->where('clans_id', $clanId)->orderBy('kill_time', 'asc')->take(5);
    }
}
