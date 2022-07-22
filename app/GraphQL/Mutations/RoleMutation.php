<?php

namespace App\GraphQL\Mutations;

use App\Models\Role;
use App\Models\User;

final class RoleMutation
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function RoleMutation($_,array $args)
    {
        Role::upsertInstance($args);
    }
}
