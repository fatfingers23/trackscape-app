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

    public function bossPbLeaderBoardByClan(int $clanId)
    {
        return $this->hasMany(BossPersonalBest::class)->with('player')->
        where('clan_id', $clanId)->orderBy('kill_time', 'asc')->get();
    }

    public function top5BossPbLeaderBoardByClan(int $clanId)
    {
        return $this->hasMany(BossPersonalBest::class)->with('player')->
        where('clan_id', $clanId)->orderBy('kill_time', 'asc')->take(5);
    }
}
