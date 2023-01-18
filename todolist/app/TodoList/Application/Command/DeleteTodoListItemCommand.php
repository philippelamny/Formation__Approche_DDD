<?php

namespace App\TodoList\Application\Command;

use App\CQS\Command;

class DeleteTodoListItemCommand implements Command
{
    public function __construct(readonly public string $id)
    {
    }
}
