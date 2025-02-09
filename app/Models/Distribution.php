<?php

namespace App\Models;

use App\Traits\HasCode;
use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distribution extends Model
{
    use HasFactory;
    use HasUser;
    use HasCode;

    protected $fillable = ['user_id', 'entity_id', 'code', 'date', 'comments'];


    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function distributionItems(): HasMany
    {
        return $this->hasMany(DistributionItem::class);
    }

}
