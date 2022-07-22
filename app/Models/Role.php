<?php

namespace App\Models;

use App\Http\Helpers\DeleteActions;
use App\Http\Helpers\Tenent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    use HasFactory,DeleteActions,Tenent;

    protected $guarded = [];

    static function upsertInstance($request)
    {
        $role = Role::updateOrCreate(
            ['id' => $request['input']['id'] ?? null],
            [
                'name' => $request['input']['name'],
                'company_id' => Auth::user()->company_id
            ]
        );
        
        $role->priviledges()->sync($request['input']['priviledges']);

        return $role;
    }


    public function deleteInstance()
    {
        $this->users()->update(['users.role_id' => 0]);
        $this->deleteWithDeattach(['priviledges']);
        return $this;
    }

    //Relations
    public function priviledges()
    {
        return $this->belongsToMany(Priviledge::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
