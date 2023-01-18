<?php

namespace Tests\Unit\Todolist;


use App\TodoList\Application\Command\UpdateTodoListItemCommand;
use App\TodoList\Application\Command\UpdateTodoListItemCommandHandler;
use App\TodoList\Application\Contract\TodoListRepository;
use App\TodoList\Domain\TodoItem;
use App\TodoList\Domain\TodoItemSnapshot;
use App\TodoList\Domain\TodoListEmptyNameException;
use App\TodoList\Domain\TodoListNotFound;
use Tests\TestCase;

class UpdateTodoListItemCommandHandlerTest extends TestCase
{
    private UpdateTodoListItemCommandHandler $handler;
    private TodoListRepository               $todoListRepository;

    public function handleWith(string $id = "1", string $name = "#TOdoList name changed", bool $isChecked = false): int
    {
        $command = new UpdateTodoListItemCommand(id: $id, name: $name, isChecked: $isChecked);

        return $this->handler->handle($command);
    }

    private function givenItems(string $number = "1", bool $isChecked = false): void
    {
        $list = [];
        while ($number > 0) {
            $list[] = TodoItem::restore(new TodoItemSnapshot("#TOdoList $number", $number, $isChecked));
            $number--;
        }

        $this->todoListRepository = new InMemoryTodoListRepository($list);
        $this->handler            = new UpdateTodoListItemCommandHandler($this->todoListRepository);
    }

    public function test_it_should_fail_when_update_item_id_not_exists(): void
    {
        $givenIdNotExists = 99;
        $this->givenItems(2);

        $this->expectException(TodoListNotFound::class);

        $this->handleWith(id: $givenIdNotExists);
    }

    public function test_it_should_fail_when_name_is_empty(): void
    {
        $this->givenItems();

        $this->expectException(TodoListEmptyNameException::class);

        $this->handleWith(name: '');
    }

    public function test_it_should_fail_when_name_contains_only_whitespace(): void
    {
        $this->givenItems();

        $this->expectException(TodoListEmptyNameException::class);

        $this->handleWith(name: "      ");
    }

    public function test_it_should_check(): void
    {
        $this->givenItems(isChecked: false);

        $this->assertFalse($this->todoListRepository->loadById("1")->getSnapshot()->isChecked);

        $id = $this->handleWith(id: "1", isChecked: true);

        $this->assertTrue($this->todoListRepository->loadById($id)->getSnapshot()->isChecked);
    }

    public function test_it_should_uncheck(): void
    {
        $this->givenItems(isChecked: true);

        $this->assertTrue($this->todoListRepository->loadById("1")->getSnapshot()->isChecked);

        $id = $this->handleWith(id: "1", isChecked: false);

        $this->assertFalse($this->todoListRepository->loadById($id)->getSnapshot()->isChecked);
    }
}
