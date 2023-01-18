<?php

namespace Tests\Unit\Todolist;


use App\TodoList\Application\Query\RetrieveTodoListItemQuery;
use App\TodoList\Application\Query\RetrieveTodoListItemQueryHandler;
use App\TodoList\Domain\TodoItem;
use App\TodoList\Domain\TodoItemSnapshot;
use App\TodoList\Domain\TodoListNotFound;
use Tests\TestCase;

class RetrieveTodoListItemQueryHandlerTest extends TestCase
{
    private RetrieveTodoListItemQueryHandler $handler;

    public function handleWith(string $id): TodoItemSnapshot
    {
        $query = new RetrieveTodoListItemQuery(id: $id);

        return $this->handler->handle($query);
    }

    private function givenItems(int $number = 1): void
    {
        $list = [];
        while ($number > 0) {
            $list[] = TodoItem::restore(new TodoItemSnapshot(name: "#TOdoList $number", id: $number, isChecked: false));
            $number--;
        }

        $todoListRepository = new InMemoryTodoListRepository($list);
        $this->handler      = new RetrieveTodoListItemQueryHandler($todoListRepository);
    }

    public function test_it_should_fail_when_handle_with_not_found_id(): void
    {
        $this->givenItems(3);

        $this->expectException(TodoListNotFound::class);

        $this->handleWith("4");
    }

    public function test_it_should_return_item(): void
    {
        $this->givenItems($number = 3);

        $actualSnapshot = $this->handleWith(id: $number);

        $this->assertEquals(
            new TodoItemSnapshot(
                name: "#TOdoList $number", id: $number, isChecked: false
            ),
            $actualSnapshot
        );
    }
}
