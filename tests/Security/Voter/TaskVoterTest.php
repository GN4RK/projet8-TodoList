<?php

namespace App\Tests\Form;

use App\Entity\Task;
use App\Entity\User;
use App\Security\TaskVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TaskVoterTest extends TestCase
{
    private $voter;
    private $token;
    private $user;

    public function setUp(): void
    {
        $this->task = new Task();
        $this->voter = new TaskVoter();
        $this->user = new User();
        $this->token = new UsernamePasswordToken($this->user, 'main', ['ROLE_USER']);
    }

    public function testOnlyTask() 
    {
        $this->assertSame(0, $this->voter->vote($this->token, null, ['edit']));
    }

    public function testBadToken() 
    {
        $token = new UsernamePasswordToken($this->user, 'mazefzfin', ['USER_ROLE']);
        $this->assertSame(-1, $this->voter->vote($token, $this->task, ['edit']));
    }

    public function testAttributeNotSupported() 
    {
        $this->assertSame(0, $this->voter->vote($this->token, $this->task, ['notsupported']));
    }

    public function testVoterEditAuthor() 
    {
        $this->task->setAuthor($this->user);
        $this->assertSame(1, $this->voter->vote($this->token, $this->task, ['edit']));
    }

    public function testVoterDeleteAuthor() 
    {
        $this->task->setAuthor($this->user);
        $this->assertSame(1, $this->voter->vote($this->token, $this->task, ['delete']));
    }

    public function testVoterToggle() 
    {
        $this->task->setAuthor($this->user);
        $this->assertSame(1, $this->voter->vote($this->token, $this->task, ['toggle']));
    }

    public function testVoterAdmin() 
    {
        $this->user->setRoles(['ROLE_ADMIN']);
        $this->assertSame(1, $this->voter->vote($this->token, $this->task, ['delete']));
    }
}