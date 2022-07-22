<?php

namespace App\GraphQL\Mutations;

use App\Models\User;

final class UploadCover
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        return User::modifyUserCover($args['file']);   
    }
}
