<?php

namespace App\Http\Controllers;

use App\CQS\CommandBus;
use App\TodoList\Application\Command\DeleteTodoListItemCommand;

class DeleteTodoListItemController
{
    public function __invoke(string $id, CommandBus $commandBus)
    {
        $commandBus->execute(new DeleteTodoListItemCommand(id: $id));
    }
}
