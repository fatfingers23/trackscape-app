<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Donation
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $donation_type_id
 * @property int $runescape_user_id
 * @property int $amount
 * @property string|null $item_name
 * @method static \Illuminate\Database\Eloquent\Builder|Donation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereDonationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereRunescapeUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Donation extends Model
{
    use HasFactory;

    public function whoDonated()
    {
        $this->belongsTo(RunescapeUser::class, "id");
    }

    public function donationType()
    {
        $this->belongsTo(D::class, "id");
    }
}
