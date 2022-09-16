<?php

namespace App\GraphQL\Mutations;

use App\Models\Attending;

final class AttendingMutation
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
        return Attending::upsertInstance($args);
    }

    public function delete($_,array $args)
    {
        $attending  = Attending::find($args['id']);
        return $attending->deleteInstance();
    }
}
