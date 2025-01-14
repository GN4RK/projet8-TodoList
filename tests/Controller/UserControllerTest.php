<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUsersListAnonymous(): void
    {
        $client = static::createClient();
        $client->request('GET', '/users');

        // Redirection
        $this->assertResponseStatusCodeSame(302);
    }

    public function testUsersListAdmin(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $admin = $userRepository->findOneById(1);

        // simulate $admin being logged in
        $client->loginUser($admin);

        $client->request('GET', '/users');

        $this->assertResponseIsSuccessful();
    }

    public function testUsersCreationUser(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $testUser = $userRepository->findOneById(2);
        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $client->request('GET', '/users/create');

        // Redirection
        $this->assertResponseStatusCodeSame(302);
    }

    public function testUsersCreationAdmin(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $admin = $userRepository->findOneById(1);
        // simulate $admin being logged in
        $client->loginUser($admin);
        $client->request('GET', '/users/create');

        $randomValue = random_int(100, 1000);
        $client->submitForm('Ajouter', [
            'user[username]' => "test$randomValue" ,
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[email]' => "test$randomValue@mail.com"
        ]);

        // Redirection when successfully created
        $this->assertResponseStatusCodeSame(302);
    }


    public function testUsersEditAnonymous(): void
    {
        $client = static::createClient();
        $client->request('GET', '/users/2/edit');
       
        // Access denied
        $this->assertResponseRedirects('http://localhost/login');
    }

    public function testUsersEditAdmin(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneById(1);
        $client->loginUser($admin);
        $client->request('GET', '/users/2/edit');

        $client->submitForm('Modifier', [
            'user[username]' => "test" ,
            'user[email]' => "testunit@mail.com"
        ]);

        // Redirection when successfully created
        $this->assertResponseStatusCodeSame(302);

    }

}
