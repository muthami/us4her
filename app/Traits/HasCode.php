<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasCode
{
    public static function bootHasCode()
    {
        static::creating(function ($model) {
            if (is_null($model->code)) {
                $model->code = \Illuminate\Support\Str::upper(Str::random(8));
            }
        });
    }
}
