<?php

namespace App\GraphQL\Queries;

use App\Models\Attending;

final class AttendingQuery
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function attendingList($_, array $args)
    {
        return Attending::filter($args);
    }
}
