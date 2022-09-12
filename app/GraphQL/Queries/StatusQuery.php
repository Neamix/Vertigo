<?php

namespace App\GraphQL\Queries;

use App\Models\Status;

final class StatusQuery
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function statusList($_, array $args)
    {
        return Status::filter($args);
    }
}
