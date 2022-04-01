<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
