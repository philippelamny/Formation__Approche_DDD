<?php

namespace App\TodoList\Application\Command;

use App\CQS\Command;

class CreateTodoListItemCommand implements Command
{

    /**
     * @param string $name
     */
    public function __construct(readonly public string $name)
    {
    }
}
