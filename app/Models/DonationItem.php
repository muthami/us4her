<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class DonationItem extends Model
{
    protected $fillable = ['donation_id', 'item_id', 'quantity'];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function inventory()
    {
        return $this->morphMany(Inventory::class, 'inventoryable');
    }
}
