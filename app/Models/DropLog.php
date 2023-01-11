<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DropLog
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $rsn
 * @property string $item_name
 * @property int $quantity
 * @property int $price
 * @method static \Illuminate\Database\Eloquent\Builder|DropLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DropLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DropLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|DropLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DropLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DropLog whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DropLog wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DropLog whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DropLog whereRsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DropLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DropLog extends Model
{
//    use HasFactory;

    protected $guarded = [];
}
