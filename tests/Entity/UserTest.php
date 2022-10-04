<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
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
        $this->assertNull($this->user->getId());
    }

    public function testUsername()
    {
        $this->user->setUsername("usernameTest");
        $this->assertSame("usernameTest", $this->user->getUsername());
    }

    public function testRoles()
    {
        $this->user->setRoles(["ROLE_USER"]);
        $this->assertSame(["ROLE_USER"], $this->user->getRoles());
    }

    public function testNoRoles()
    {
        $this->assertSame(["ROLE_USER"], $this->user->getRoles());
    }

    public function testPassword()
    {
        $this->user->setPassword('$2y$13$fdxcZGs48zHbS3PoI.o66ebjrSIs6gnrLe99qWqvP3rypakhPbCgu');
        $this->assertSame('$2y$13$fdxcZGs48zHbS3PoI.o66ebjrSIs6gnrLe99qWqvP3rypakhPbCgu', $this->user->getPassword());
    }

    public function testEmail()
    {
        $this->user->setEmail("test@mail.com");
        $this->assertSame("test@mail.com", $this->user->getEmail());
    }

    public function testSalt()
    {
        $this->assertSame(null, $this->user->getSalt());
    }

    public function testUserIdentifier()
    {
        $this->assertSame($this->user->getUsername(), $this->user->getUserIdentifier());
    }

    public function testTask()
    {
        $this->user->addTask($this->task);
        $this->assertSame($this->user->getTasks()[0], $this->task);
        $this->user->removeTask($this->task);
        $this->assertEmpty($this->user->getTasks());
    }

}