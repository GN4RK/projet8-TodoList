<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/tasks');

        $this->assertResponseIsSuccessful();
    }
    
    public function testCreateAnonymous(): void
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/create');
        // access denied
        $this->assertResponseRedirects('http://localhost/login');
    }

    public function testCreateLoggedUser(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneById(2);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/create');

        $client->submitForm('Ajouter', [
            'task[title]' => 'title',
            'task[content]' => 'content'
        ]);

        $this->assertResponseRedirects('/tasks');
    }

    public function testEditAnonymous(): void
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/12/edit');
        // access denied
        $this->assertResponseRedirects('http://localhost/login');
    }

    public function testEditAuthor(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneById(2);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/32/edit');

        $client->submitForm('Modifier', [
            'task[title]' => 'titleedit',
            'task[content]' => 'contentedit'
        ]);

        $this->assertResponseRedirects('/tasks');
    }

    public function testToggleAnonymous(): void
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/12/toggle');
        // access denied
        $this->assertResponseRedirects('http://localhost/login');
    }

    public function testToggleLoggedUser(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneById(2);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/12/toggle');
        
        $this->assertResponseRedirects();
    }

    public function testDeleteAnonymous(): void
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/12/delete');
        // access denied
        $this->assertResponseRedirects('http://localhost/login');
    }

}