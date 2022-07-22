<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;

final class UserAuthQuery
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function getAuthedUser($_, array $args)
    {
        return (Auth::user()) ? Auth::user() : null;
    }
}
