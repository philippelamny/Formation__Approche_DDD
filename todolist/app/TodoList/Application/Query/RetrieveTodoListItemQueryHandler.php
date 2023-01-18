<?php

namespace App\TodoList\Application\Query;

use App\CQS\QueryHandler;
use App\TodoList\Application\Contract\TodoListRepository;
use App\TodoList\Domain\TodoItemSnapshot;

class RetrieveTodoListItemQueryHandler implements QueryHandler
{
    public function __construct(readonly private TodoListRepository $todoListRepository)
    {
    }

    public function handle(RetrieveTodoListItemQuery $query): TodoItemSnapshot
    {
        return $this->todoListRepository->loadById($query->id)->getSnapshot();
    }
}
