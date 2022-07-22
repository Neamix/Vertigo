<?php

namespace App\GraphQL\Mutations;

use App\Models\User;

final class UploadAvatar
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        return User::modifyUserAvatar($args['file']);
    }
}
