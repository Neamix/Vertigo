<?php

namespace App\Models;

use App\Http\Helpers\DeleteActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory,DeleteActions;

    static function upsertInstance($request)
    {
        $role = Role::updateOrCreate(
            ['id' => 1],
            [
                'name' => $request->name
            ]
        );

        return $role;
    }

    public function deleteInstance()
    {
        $this->deleteWithDeattach(['priviledges']);
    }

    //Relations
    public function priviledges()
    {
        return $this->belongsToMany(Priviledge::class);
    }

    public function users()
    {
        return $this->belongsToMany(Role::class);
    }
}
