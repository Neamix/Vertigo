<?php

namespace App\Models;

use App\Http\Helpers\Tenent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attending extends Model
{
    use HasFactory,Tenent;

    protected $guarded = [];

    static function upsertInstance($request)
    {
        $attending = Attending::updateOrCreate(
            ['id' => $request['input']['id'] ?? null],
            [
                'name' => $request['input']['name'],
                'company_id' => Auth::user()->company_id
            ]
        );

        $attending->requests()->sync($request['input']['request']);
        $attending->statuses()->sync($request['input']['status']);

        return [
            'status' => 'Success'
        ];
    }

    public function deleteInstance()
    {
        $this->requests()->detach();
        $this->statuses()->detach();
        $this->delete();

        return [
            'status' => 'Succes'
        ];
    }

    //Scope

    public function scopeFilter($query,$search_array) 
    {
        $query->where('company_id',Auth::user()->company_id);

        if ( ! empty($search_array['input']['name']) ) {
            $query->where('name', 'LIKE', '%'. $search_array['input']['name'] .'%');
        }

        return $query;
    }

    //Relations

    public function requests()
    {
        return $this->belongsToMany(Request::class);
    }
    
    public function statuses()
    {
        return $this->belongsToMany(Status::class);
    }


    
}
