<?php

namespace App\Http\Controllers;

use App\CQS\CommandBus;
use App\TodoList\Application\Command\CreateTodoListItemCommand;
use Illuminate\Http\Request;

class CreateTodoListItemController
{
    public function __invoke(Request $request, CommandBus $commandBus)
    {
        return $commandBus->execute(new CreateTodoListItemCommand(name: $request->get('name') ?? ""));
    }
}
