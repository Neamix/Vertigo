<?php

namespace App\GraphQL\Mutations;

use App\Models\Request;

final class RequestMutation
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
        return Request::upsertInstance($args);
    }

    public function delete($_,array $args)
    {
        $request = Request::find($args['id']);
        return $request->deleteInstance();
    }
}
