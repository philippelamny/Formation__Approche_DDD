<?php

namespace App\TodoList\Domain;

class TodoListEmptyNameException extends \Exception
{
    public function __construct()
    {
        parent::__construct("TodoListEmptyNameException", 500);
    }
}
