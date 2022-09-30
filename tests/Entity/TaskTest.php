<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private User $user;
    private Task $task;
    
    public function setUp(): void
    {
        $this->user = new User();
        $this->task = new Task();
    }

    public function testId()
    {
        $this->assertNull($this->task->getId());
    }

    public function testCreatedAt()
    {
        $this->task->setCreatedAt("10/01/2022");
        $this->assertSame("10/01/2022", $this->task->getCreatedAt());
    }

    public function testTitle()
    {
        $this->task->setTitle("title");
        $this->assertSame("title", $this->task->getTitle());
    }

    public function testContent()
    {
        $this->task->setContent("Content");
        $this->assertSame("Content", $this->task->getContent());
    }

    public function testIsDoneWhenCreated()
    {
        $this->assertFalse($this->task->isDone());
    }

    public function testIsDoneWhenToggled()
    {
        $this->task->toggle(true);
        $this->assertTrue($this->task->isDone());
    }

    public function testAuthorEmpty()
    {
        $this->assertSame(null, $this->task->getAuthor());
    }

    public function testAuthor()
    {
        $this->task->setAuthor($this->user);
        $this->assertSame($this->user, $this->task->getAuthor());
    }

}