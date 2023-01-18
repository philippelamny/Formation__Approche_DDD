<?php

namespace App\Http\Controllers;

use App\CQS\QueryBus;
use App\TodoList\Application\Query\RetrieveTodoListItemQuery;

class RetrieveTodoListItemController
{
    public function __invoke(string $id, QueryBus $queryBus)
    {
        $item = $queryBus->ask(new RetrieveTodoListItemQuery(id: $id));

        return json_encode($item);
    }
}
