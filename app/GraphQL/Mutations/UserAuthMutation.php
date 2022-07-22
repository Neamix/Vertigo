<?php

namespace App\GraphQL\Mutations;

use App\Models\User;

final class UserAuthMutation
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function login($_, array $args)
    {
        return User::login($args);
    }

    public function upsert($_, array $args)
    {
        return User::upsertInstance($args);
    }

    public function forgetPassword($_, array $args)
    {
        $user = User::where('email',$args['input']['email'])->first();
        return $user->sendForgetEmail();
    }

    public function resetPassword($_, array $args)
    {
        $user = User::where('email',$args['input']['email'])->first();
        return $user->resetPassword($args);
    }
}
