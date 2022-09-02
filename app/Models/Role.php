<?php

namespace App\Models;

use App\Http\Helpers\DeleteActions;
use App\Http\Helpers\Tenent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    use HasFactory,DeleteActions;

    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope(function(Builder $builder){
            if ( Auth::guard('api')->check() ) {
                if( ! Auth::user()->isPartner() ) {
                    $builder->where('company_id',Auth::user()->id);
                }
            }
        });
    }

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

    static function getRoleList()
    {
        return Role::all();
    }

    //scope

    public function scopeFilter($query,$search_array) 
    {
        $query->where('company_id',Auth::user()->company_id);

        if ( ! empty($search_array['input']['name']) ) {
            $query->where('name', 'LIKE', '%'. $search_array['input']['name'] .'%');
        }

        return $query;
    }

    //Relations
    public function priviledges()
    {
        return $this->belongsToMany(Priviledge::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
