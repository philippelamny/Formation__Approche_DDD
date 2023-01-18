<?php

namespace App\TodoList\Application\Gateway;

use App\TodoList\Application\Contract\TodoListRepository;
use App\TodoList\Domain\TodoItem;
use App\TodoList\Domain\TodoItemSnapshot;
use App\TodoList\Domain\TodoListNotFound;
use Illuminate\Support\Facades\Http;

class AwsTodoListRepository implements TodoListRepository
{
    public function loadById(string $id): TodoItem
    {
        $response = Http::get("https://arfkcpx7m7.execute-api.us-east-1.amazonaws.com/dev/todos/{$id}");

        if ($response->failed()) {
            throw $response->toException();
        }

        $item = $response->json();
        if (is_null($item)) {
            throw new TodoListNotFound($id);
        }

        return TodoItem::restore(
            new TodoItemSnapshot(name: $item['text'], id: $item['id'], isChecked: $item['checked'])
        );
    }

    public function create(TodoItem $newTodoItem): void
    {
        $snapshot = $newTodoItem->getSnapshot();

        $response = Http::post("https://arfkcpx7m7.execute-api.us-east-1.amazonaws.com/dev/todos", [
            'text' => $snapshot->name
        ]);

        if ($response->failed()) {
            throw $response->toException();
        }

        $newTodoItem->setId($response->json('id'));
    }

    public function modify(TodoItem $item): void
    {
        $snapshot = $item->getSnapshot();

        $response = Http::put("https://arfkcpx7m7.execute-api.us-east-1.amazonaws.com/dev/todos/{$snapshot->id}", [
            'text' => $snapshot->name,
            'checked' => $snapshot->isChecked
        ]);

        if ($response->failed()) {
            throw $response->toException();
        }
    }

    /**
     * @return array<TodoItemSnapshot>
     */
    public function fetchAll(): array
    {
        // On pourrait optimiser avec un yield
        $response = Http::get("https://arfkcpx7m7.execute-api.us-east-1.amazonaws.com/dev/todos");
        $result = $response->json();
        $list = [];
        foreach ($result as $item) {
            $list[] = new TodoItemSnapshot(name: $item['text'], id: $item['id'], isChecked: $item['checked']);
        }
        return $list;
    }

    public function delete(string $id): void
    {
        $response = Http::delete("https://arfkcpx7m7.execute-api.us-east-1.amazonaws.com/dev/todos/{$id}");

        if ($response->failed()) {
            throw $response->toException();
        }
    }
}
