<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
        // Admin user
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword('$2y$13$fdxcZGs48zHbS3PoI.o66ebjrSIs6gnrLe99qWqvP3rypakhPbCgu'); // = 'test'
        $admin->setEmail('admin@mail.com');
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        // Simple user
        $user = new User();
        $user->setUsername('user');
        $user->setPassword('$2y$13$fdxcZGs48zHbS3PoI.o66ebjrSIs6gnrLe99qWqvP3rypakhPbCgu'); // = 'test'
        $user->setEmail('user@mail.com');
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        // anonymous tasks
        for ($i = 0; $i < 5; $i++) {
            $task = new Task();
            $task->setTitle('title');
            $task->setContent('content');
            $manager->persist($task);
        }

        $task = new Task();
        $task->setTitle('title');
        $task->setContent('content');
        $task->setAuthor($admin);
        $task->toggle(true);
        $manager->persist($task);

        $task = new Task();
        $task->setTitle('title');
        $task->setContent('content');
        $task->setAuthor($user);
        $manager->persist($task);

        $manager->flush();
    }
}
