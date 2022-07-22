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

    public function upsert($_,array $args)
    {
        return Role::upsertInstance($args);
    }

    public function delete($_,array $args)
    {
        $role = Role::find($args['id']);
        return $role->deleteInstance();
    }
}
