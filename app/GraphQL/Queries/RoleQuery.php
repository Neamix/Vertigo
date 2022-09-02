<?php

namespace App\GraphQL\Queries;

use App\Models\Role;

final class RoleQuery
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function roleList($_, array $args)
    {
        return Role::filter($args);
    }
}
