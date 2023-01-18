<?php

namespace App\TodoList\Application\Command;

use App\CQS\CommandHandler;
use App\TodoList\Application\Contract\TodoListRepository;

class DeleteTodoListItemCommandHandler implements CommandHandler
{
    public function __construct(readonly private TodoListRepository $todoListRepository)
    {
    }

    public function handle(DeleteTodoListItemCommand $command): void
    {
        $this->todoListRepository->loadById($command->id);

        $this->todoListRepository->delete($command->id);
    }
}
