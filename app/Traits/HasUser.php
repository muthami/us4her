<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasUser
{
    public static function bootHasUser()
    {
        static::creating(function ($model) {
            if (is_null($model->user_id) && Auth::check()) {
                $model->user_id = Auth::id();
            } else {
                $model->user_id = 1;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
