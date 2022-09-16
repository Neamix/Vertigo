<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AttendingPolicy
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
        if ( Auth::user()->hasPriviledge(VIEW_ATTENDING) || Auth::user()->hasPriviledge(UPSERT_ATTENDING)  || Auth::user()->hasPriviledge(DELETE_ATTENDING)) {
            return true;
        } else {
            return false;
        }
    }

    public function upsert()
    {
        if ( Auth::user()->hasPriviledge(UPSERT_ATTENDING) ) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        if ( Auth::user()->hasPriviledge(DELETE_ATTENDING) ) {
            return true;
        } else {
            return false;
        }
    }
}
