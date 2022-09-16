<?php

namespace App\Models;

use App\Http\Helpers\DeleteActions;
use App\Http\Helpers\Tenent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Status extends Model
{
    use HasFactory,Tenent,DeleteActions;

    protected $guarded = [];
    protected $table = 'statuses';

    static function upsertInstance($status)
    {
        $status = Status::updateOrCreate(
            ['id' => $status['input']['id'] ?? null],
            [
                'name' => $status['input']['name'],
                'color' => $status['input']['color'],
                'company_id' => Auth::user()->company_id
            ]
        );
        

        return [
            'status' => 'Success'
        ];
    }


    public function deleteInstance()
    {
        $this->delete();
        return [
            'status' => 'Success'
        ];
    }

    static function getStatusList()
    {
        return Status::all();
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
}
