<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priviledge extends Model
{
    use HasFactory;

    static function parents()
    {
        return Priviledge::where('parent_id',null)->get();
    }

    public function children()
    {
        return $this->hasMany(Priviledge::class,'parent_id');
    }
}
