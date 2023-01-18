<?php

namespace App\TodoList\Application\Command;

use App\CQS\CommandHandler;
use App\TodoList\Application\Contract\TodoListRepository;
use App\TodoList\Domain\TodoItem;
use App\TodoList\Domain\TodoListEmptyNameException;

class CreateTodoListItemCommandHandler implements CommandHandler
{
    public function __construct(readonly private TodoListRepository $todoListRepository)
    {
    }

    /**
     * @throws TodoListEmptyNameException
     */
    public function handle(CreateTodoListItemCommand $command): string
    {
        $newTodoItem = TodoItem::create($command->name);

        $this->todoListRepository->create($newTodoItem);

        return $newTodoItem->getId();
    }
}
