<?php

namespace App\TodoList\Domain;

class TodoItem
{
    private function __construct(private string $name, private ?string $id = null, private bool $isChecked = false)
    {
    }

    /**
     * @throws TodoListEmptyNameException
     */
    public static function create(
        string $name
    ): static {
        $name = trim($name);
        if (empty($name)) {
            throw new TodoListEmptyNameException();
        }

        return new static(name: $name);
    }

    /**
     * @throws TodoListEmptyNameException
     */
    public function modify(string $name, bool $isChecked): static
    {
        $name = trim($name);
        if (empty($name)) {
            throw new TodoListEmptyNameException();
        }
        $this->name      = $name;
        $this->isChecked = $isChecked;

        return $this;
    }

    public static function restore(TodoItemSnapshot $snapshot): static
    {
        return new static(
            name: $snapshot->name,
            id: $snapshot->id,
            isChecked: $snapshot->isChecked
        );
    }

    public function getSnapshot(): TodoItemSnapshot
    {
        return new TodoItemSnapshot(
            name: $this->name,
            id: $this->id,
            isChecked: $this->isChecked
        );
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
