<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $clan_id
 * @property $collection_count
 * @property $runescape_users_id
 */
class CollectionLog extends Model
{
    protected $guarded = [];

    public function player()
    {
        return $this->hasOne(RunescapeUser::class, 'id', 'runescape_users_id');
    }


}