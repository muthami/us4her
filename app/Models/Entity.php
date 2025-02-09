<?php

namespace App\Models;

use App\Traits\HasCode;
use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;
    use HasCode;
    use HasUser;

    protected $guarded = ['id'];

}
