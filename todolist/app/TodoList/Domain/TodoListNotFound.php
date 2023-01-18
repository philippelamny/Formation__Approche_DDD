<?php

namespace App\TodoList\Domain;

class TodoListNotFound extends \Exception
{

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        parent::__construct("Item #{$id} not found", 500);
    }
}
