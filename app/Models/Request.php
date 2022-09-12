<?php

namespace App\Models;

use App\Http\Helpers\DeleteActions;
use App\Http\Helpers\Tenent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Request extends Model
{
    use HasFactory,Tenent,DeleteActions;

    protected $guarded = [];

    static function upsertInstance($request)
    {
        $request = Request::updateOrCreate(
            ['id' => $request['input']['id'] ?? null],
            [
                'name' => $request['input']['name'],
                'request_type_id' => $request['input']['type'],
                'company_id' => Auth::user()->company_id
            ]
        );
        

        return [
            'status' => 'Success'
        ];
    }


    public function deleteInstance()
    {
        $this->deleteWithDeattach(['users']);
        return $this;
    }

    static function getRequestList()
    {
        return Request::all();
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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function requestType()
    {
        return $this->belongsTo(RequestType::class);
    }
}
