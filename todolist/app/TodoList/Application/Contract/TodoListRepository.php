<?php

namespace App\TodoList\Application\Contract;

use App\TodoList\Domain\TodoItem;
use App\TodoList\Domain\TodoItemSnapshot;
use App\TodoList\Domain\TodoListNotFound;

interface TodoListRepository
{
    /**
     * @throws TodoListNotFound
     */
    public function loadById(string $id): TodoItem;

    public function create(TodoItem $newTodoItem): void;

    public function modify(TodoItem $item): void;

    /**
     * @return array<TodoItemSnapshot>
     */
    public function fetchAll(): array;

    public function delete(string $id): void;
}
