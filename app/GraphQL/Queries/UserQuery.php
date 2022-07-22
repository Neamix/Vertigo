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
        return User::filter($args);
    }

    public function userExport($_, array $args)
    {
        return User::exportUserExcel($args['type']);
    }
}
