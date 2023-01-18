<?php

namespace App\Http\Controllers;

use App\CQS\QueryBus;
use App\TodoList\Application\Query\RetrieveTodoListQuery;

class RetrieveTodoListController
{
    public function __invoke(QueryBus $queryBus)
    {
        return $queryBus->ask(new RetrieveTodoListQuery());
    }
}
