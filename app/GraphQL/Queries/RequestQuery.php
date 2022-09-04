<?php

namespace App\GraphQL\Queries;

use App\Models\Request;

final class RequestQuery
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function requestList($_, array $args)
    {
        return Request::filter($args);
    }
}
