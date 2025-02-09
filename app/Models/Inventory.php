<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasUser;
    use SoftDeletes;

    protected $fillable = ['user_id', 'item_id', 'quantity', 'inventoryable_id', 'inventoryable_type'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function inventoryable(): MorphTo
    {
        return $this->morphTo();
    }
}
