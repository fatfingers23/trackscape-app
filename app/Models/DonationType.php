<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DonationType
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int $clan_id
 * @property int $gp
 * @method static \Illuminate\Database\Eloquent\Builder|DonationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DonationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DonationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|DonationType whereClanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonationType whereGp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonationType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DonationType extends Model
{
    use HasFactory;

    public function donations()
    {
        $this->hasMany(Donation::class, 'donation_types_id');
    }
}
