<?php

namespace App\Http\Controllers;

use App\CQS\CommandBus;
use App\TodoList\Application\Command\UpdateTodoListItemCommand;
use Illuminate\Http\Request;

class UpdateTodoListItemController
{
    public function __invoke(string $id, Request $request, CommandBus $commandBus)
    {
        $isChecked = $request->get('isChecked', null);
        if ($isChecked === null) {
            throw new \Exception("le champs 'isChecked' n'est pas spécifié", 500);
        }

        $name = $request->get('name', null);
        if ($name === null) {
            throw new \Exception("le champs 'name' n'est pas spécifié", 500);
        }

        return $commandBus->execute(
            new UpdateTodoListItemCommand(
                    id: $id, name: $name, isChecked: $isChecked
            )
        );
    }
}
