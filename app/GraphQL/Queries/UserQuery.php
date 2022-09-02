<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

final class UserQuery
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function userList($_, array $args)
    {
        $filter = $args['input'] ?? $args;
        return User::filter($filter);
    }

    public function roleList()
    {
        return [];
    }

    public function userExport($_, array $args)
    {
        return User::exportUserFiles($args);
    }
}
