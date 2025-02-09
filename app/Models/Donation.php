<?php

namespace App\Models;

use App\Traits\HasCode;
use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;
    use HasUser;
    use HasCode;

    protected $fillable = ['user_id', 'donor_id', 'code', 'date', 'comments'];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function donationItems()
    {
        return $this->hasMany(DonationItem::class);
    }

}
