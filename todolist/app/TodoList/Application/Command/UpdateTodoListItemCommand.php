<?php

namespace App\TodoList\Application\Command;

use App\CQS\Command;

class UpdateTodoListItemCommand implements Command
{
    public function __construct(readonly public string $id, readonly public string $name, readonly public bool $isChecked)
    {
    }
}
