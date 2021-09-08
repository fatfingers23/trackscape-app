<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $name
 * @property $clan_id
 * @property $competitions_id
 */
class DonationType extends Model
{
    use HasFactory;

    public function donations()
    {
        $this->hasMany(Donation::class, 'donation_types_id');
    }
}
