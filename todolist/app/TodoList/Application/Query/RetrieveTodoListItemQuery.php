<?php

namespace App\TodoList\Application\Query;

use App\CQS\Query;

class RetrieveTodoListItemQuery implements Query
{

    /**
     * @param string $id
     */
    public function __construct(readonly public string $id)
    {
    }
}
