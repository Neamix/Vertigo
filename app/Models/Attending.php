<?php

namespace App\Models;

use App\Http\Helpers\Tenent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

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
        
        $request_array = [];

        foreach( $request['input']['request'] as $request_values ) {
            $request_array[$request_values['request_id']] = ['value' => $request_values['value']];
        }

        $attending->requests()->sync($request_array);
        $attending->status()->sync($request['input']['status']);

        return [
            'status' => 'Success'
        ];
    }

    public function deleteInstance()
    {
        $this->requests()->detach();
        $this->status()->detach();
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
        return $this->belongsToMany(Request::class)->withPivot('value');
    }
    
    public function status()
    {
        return $this->belongsToMany(Status::class);
    }


    
}
