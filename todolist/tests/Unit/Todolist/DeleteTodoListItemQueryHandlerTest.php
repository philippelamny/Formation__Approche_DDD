<?php

namespace Tests\Unit\Todolist;


use App\TodoList\Application\Command\DeleteTodoListItemCommand;
use App\TodoList\Application\Command\DeleteTodoListItemCommandHandler;
use App\TodoList\Application\Contract\TodoListRepository;
use App\TodoList\Domain\TodoItem;
use App\TodoList\Domain\TodoItemSnapshot;
use App\TodoList\Domain\TodoListNotFound;
use Tests\TestCase;

class DeleteTodoListItemQueryHandlerTest extends TestCase
{
    private DeleteTodoListItemCommandHandler $handler;
    private TodoListRepository               $todoListRepository;

    public function handleWith(string $id): void
    {
        $query = new DeleteTodoListItemCommand(id: $id);

        $this->handler->handle($query);
    }

    private function givenItems(int $number = 1): void
    {
        $list = [];
        while ($number > 0) {
            $list[] = TodoItem::restore(new TodoItemSnapshot(name: "#TOdoList $number", id: $number, isChecked: !($number % 2 == 0)));
            $number--;
        }

        $this->todoListRepository = new InMemoryTodoListRepository($list);
        $this->handler            = new DeleteTodoListItemCommandHandler($this->todoListRepository);
    }

    public function test_it_should_fail_for_not_found_id(): void
    {
        $this->givenItems(3);

        $this->expectException(TodoListNotFound::class);

        $this->handleWith("4");
    }

    public function test_it_should_get_count_decrease(): void
    {
        $this->givenItems(5);

        $this->handleWith(4);

        $result = $this->todoListRepository->fetchAll();

        $this->assertCount(4, $result);
    }

    public function test_it_should_delete(): void
    {
        $this->givenItems(5);

        $idToDelete = 4;
        // Assure qu'il existe
        $this->todoListRepository->loadById($idToDelete);

        // WHEN
        $this->handleWith($idToDelete);

        //THEN
        $this->expectException(TodoListNotFound::class);
        $this->todoListRepository->loadById($idToDelete);
    }
}
