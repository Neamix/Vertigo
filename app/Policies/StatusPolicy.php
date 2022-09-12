<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view()
    {
        if ( Auth::user()->hasPriviledge(VIEW_REQUEST) || Auth::user()->hasPriviledge(UPSERT_REQUEST)  || Auth::user()->hasPriviledge(DELETE_REQUEST)) {
            return true;
        } else {
            return false;
        }
    }

    public function upsert()
    {
        if ( Auth::user()->hasPriviledge(UPSERT_REQUEST) ) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        if ( Auth::user()->hasPriviledge(DELETE_REQUEST) ) {
            return true;
        } else {
            return false;
        }
    }
}
