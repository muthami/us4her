<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionItem extends Model
{
    use HasFactory;

    protected $fillable = ['distribution_id', 'item_id', 'quantity'];

    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'inventoryable');
    }
}
