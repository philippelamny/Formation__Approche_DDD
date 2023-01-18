<?php

namespace Tests\Unit\Todolist;

use App\TodoList\Application\Contract\TodoListRepository;
use App\TodoList\Domain\TodoItem;
use App\TodoList\Domain\TodoListNotFound;
use Faker\Provider\Uuid;

class InMemoryTodoListRepository implements TodoListRepository
{
    /** @param array<TodoItem> $todoList */
    public function __construct(private array $todoList = [])
    {
    }

    /**
     * @throws TodoListNotFound
     */
    public function loadById(string $id): TodoItem
    {
        foreach ($this->todoList as $item) {
            $snapshot = $item->getSnapshot();
            if ($snapshot->id === $id) {
                return $item;
            }
        }

        throw new TodoListNotFound($id);
    }

    public function create(TodoItem $newTodoItem): void
    {
        $newTodoItem->setId(Uuid::uuid());

        $this->todoList[] = $newTodoItem;
    }

    public function modify(TodoItem $item): void
    {
        // Done by reference
    }

    public function fetchAll(): array
    {
        return array_map(fn($item) => $item->getSnapshot(), $this->todoList);
    }

    public function delete(string $id): void
    {
        $this->todoList = array_filter($this->todoList, fn($item) => $item->getId() !== $id);
    }
}
