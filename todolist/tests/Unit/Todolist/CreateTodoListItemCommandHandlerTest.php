<?php

namespace Tests\Unit\Todolist;


use App\TodoList\Application\Command\CreateTodoListItemCommand;
use App\TodoList\Application\Command\CreateTodoListItemCommandHandler;
use App\TodoList\Application\Contract\TodoListRepository;
use App\TodoList\Domain\TodoListEmptyNameException;
use Tests\TestCase;

class CreateTodoListItemCommandHandlerTest extends TestCase
{
    private CreateTodoListItemCommandHandler $handler;
    private TodoListRepository               $todoListRepository;

    public function handleWith(string $name = "#TOdoList new"): string
    {
        $command = new CreateTodoListItemCommand(name: $name);

        return $this->handler->handle($command);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->todoListRepository = new InMemoryTodoListRepository();
        $this->handler            = new CreateTodoListItemCommandHandler($this->todoListRepository);
    }

    public function test_it_should_fail_when_name_is_empty(): void
    {
        $this->expectException(TodoListEmptyNameException::class);

        $this->handleWith("");
    }

    public function test_it_should_fail_when_name_contains_only_whitespace(): void
    {
        $this->expectException(TodoListEmptyNameException::class);

        $this->handleWith("      ");
    }

    public function test_it_should_create_with_id_generated(): void
    {
        $newTodoItemId = $this->handleWith();

        $this->assertNotNull($newTodoItemId);
    }

    public function test_it_should_trim_the_name(): void
    {
        $expectedName = 'Name Given';
        $id           = $this->handleWith("   $expectedName   ");

        $actualName = $this->todoListRepository->loadById($id)->getSnapshot()->name;
        $this->assertEquals($expectedName, $actualName);
    }

    public function test_it_should_create_with_isChecked_as_false(): void
    {
        $id = $this->handleWith();

        $actualIsChecked = $this->todoListRepository->loadById($id)->getSnapshot()->isChecked;
        $this->assertEquals(false, $actualIsChecked);
    }
}
