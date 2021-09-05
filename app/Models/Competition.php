<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $wom_comp_id
 * @property $donation_type_id Donation type will be the name of the comp
 * @property $clan_id
 * @property $wom_verification_code
 * @property $buy_in_amount
 */
class Competition extends Model
{
    use HasFactory;

    public function donationType()
    {
        $this->hasOne(DonationType::class);
    }

}
