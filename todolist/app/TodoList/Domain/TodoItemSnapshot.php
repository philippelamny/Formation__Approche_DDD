<?php

namespace App\TodoList\Domain;

class TodoItemSnapshot
{
    public function __construct(
        readonly public string $name,
        readonly public ?string $id,
        readonly public bool $isChecked,
    ) {
    }
}
