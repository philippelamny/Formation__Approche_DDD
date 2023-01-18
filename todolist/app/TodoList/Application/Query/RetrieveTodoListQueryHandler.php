<?php

namespace App\TodoList\Application\Query;

use App\CQS\QueryHandler;
use App\TodoList\Application\Contract\TodoListRepository;
use App\TodoList\Domain\TodoItemSnapshot;

class RetrieveTodoListQueryHandler implements QueryHandler
{
    public function __construct(readonly private TodoListRepository $todoListRepository)
    {
    }

    /**
     * @return array<TodoItemSnapshot>
     */
    public function handle(RetrieveTodoListQuery $query): array
    {

        return $this->todoListRepository->fetchAll();
    }
}
