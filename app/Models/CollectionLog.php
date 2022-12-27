<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CollectionLog
 *
 * @property $clan_id
 * @property $collection_count
 * @property $runescape_users_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RunescapeUser|null $player
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionLog whereClanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionLog whereCollectionCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionLog whereRunescapeUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CollectionLog extends Model
{
    protected $guarded = [];

    public function player()
    {
        return $this->hasOne(RunescapeUser::class, 'id', 'runescape_users_id');
    }


}