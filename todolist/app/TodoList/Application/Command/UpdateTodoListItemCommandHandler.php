<?php

namespace App\TodoList\Application\Command;

use App\CQS\CommandHandler;
use App\TodoList\Application\Contract\TodoListRepository;

class UpdateTodoListItemCommandHandler implements CommandHandler
{
    public function __construct(readonly private TodoListRepository $todoListRepository)
    {
    }

    public function handle(UpdateTodoListItemCommand $command): string
    {
        $item = $this->todoListRepository->loadById($command->id);

        $item->modify(name: $command->name, isChecked: $command->isChecked);

        $this->todoListRepository->modify($item);

        return $item->getId();
    }
}
