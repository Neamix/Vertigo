<?php

namespace App\GraphQL\Queries;

use App\Models\Priviledge;

final class PriviledgeQuery
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function getPriviledges($_, array $args)
    {
        return Priviledge::parents();
    }
}
