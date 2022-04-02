<?php

namespace App\Models;

use App\Jobs\PersonalBestJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
