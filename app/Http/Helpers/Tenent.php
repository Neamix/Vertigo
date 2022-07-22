<?php 

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;

trait Tenent {
    static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($model) {
            dd(Auth::user());
            $model->where('company_id',Auth::user()->company_id);
        });
    }
}