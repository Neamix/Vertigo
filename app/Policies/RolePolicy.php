<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class RolePolicy
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
        if ( Auth::user()->hasPriviledge(VIEW_ROLE) || Auth::user()->hasPriviledge(UPSERT_ROLE)  || Auth::user()->hasPriviledge(DELETE_ROLE)) {
            return true;
        } else {
            return false;
        }
    }

    public function upsert()
    {
        if ( Auth::user()->hasPriviledge(UPSERT_ROLE) ) {
            return true;
        } else {
            return false;
        }
    }
}
