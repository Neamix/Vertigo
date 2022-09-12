<?php

namespace App\GraphQL\Mutations;

use App\Models\Status;

final class StatusMutation
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function upsert($_,array $args)
    {
        return Status::upsertInstance($args);
    }

    public function delete($_,array $args)
    {
        $status = Status::find($args['id']);
        return $status->deleteInstance();
    }
}
