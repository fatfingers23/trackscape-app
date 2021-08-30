<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    public function whoDonated()
    {
        $this->belongsTo(RunescapeUser::class, "id");
    }

    public function donationType()
    {
        $this->belongsTo(DonationType::class, "id");
    }
}
