<?php

namespace Tests\Unit\Todolist;


use App\TodoList\Application\Query\RetrieveTodoListQuery;
use App\TodoList\Application\Query\RetrieveTodoListQueryHandler;
use App\TodoList\Domain\TodoItem;
use App\TodoList\Domain\TodoItemSnapshot;
use Tests\TestCase;

class RetrieveTodoListQueryHandlerTest extends TestCase
{
    private RetrieveTodoListQueryHandler $handler;

    /** @return array<TodoItemSnapshot> */
    public function handleWith(): array
    {
        $query = new RetrieveTodoListQuery();

        return $this->handler->handle($query);
    }

    private function givenItems(int $number = 1): void
    {
        $list = [];
        while ($number > 0) {
            $list[] = TodoItem::restore(new TodoItemSnapshot(name: "#TOdoList $number", id: $number, isChecked: !($number % 2 == 0)));
            $number--;
        }

        $todoListRepository = new InMemoryTodoListRepository($list);
        $this->handler      = new RetrieveTodoListQueryHandler($todoListRepository);
    }

    public function test_it_should_return_empty_given_empty_list(): void
    {
        $this->givenItems(0);

        $this->assertEmpty($this->handleWith());
    }

    /**
     * @dataProvider givenNumberOfItems
     */
    public function test_it_should_return_items(int $givenNumberOfItems): void
    {
        $this->givenItems($givenNumberOfItems);

        $result = $this->handleWith();

        $this->assertCount($givenNumberOfItems, $result);
        foreach ($result as $itemActual) {
            $expectedItem = new TodoItemSnapshot(name: "#TOdoList $itemActual->id", id: $itemActual->id, isChecked: !($itemActual->id % 2 == 0));
            $this->assertEquals($expectedItem, $itemActual);
        }
    }

    public function givenNumberOfItems(): array
    {
        return [
            'number items : 1' => [1],
            'number items : 3' => [3],
            'number items : 5' => [5],
        ];
    }
}
