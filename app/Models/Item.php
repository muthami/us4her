<?php

namespace App\Models;

use App\Traits\HasCode;
use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    use HasUser;
    use HasCode;

    protected $fillable = ['user_id', 'code', 'name'];
}
