<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class UserMutation
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function delete($_,array $args)
    {
        $user = User::find($args['input']['id']);
        return $user->deleteInstance();
    }

    public function toggleUserActivate($_,array $args)
    {
        $user = User::find($args['id']);
        return $user->toggleUserActivateInstance();
    }

    public function addRoleToUser($_,array $args)
    {
        return User::find($args['user_id'])->addRole($args['role_id']);
    }
}
