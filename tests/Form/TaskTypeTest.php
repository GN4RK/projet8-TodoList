<?php

namespace App\Tests\Form;

use App\Form\TaskType;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Security\Core\Security;

class TaskTypeTest extends WebTestCase
{

    // protected function setUp(): void
    // {
    //     $this->client = static::createClient();
    //     $this->client->followRedirects();
    // }

    // public function testSubmitValidDataTask() 
    // {
    //     $userRepository = static::getContainer()->get(UserRepository::class);

    //     // retrieve the test user
    //     $testUser = $userRepository->findOneById(1);

    //     // simulate $testUser being logged in
    //     $this->client->loginUser($testUser);

    //     $formData = [
    //         'title' => 'title',
    //         'content' => 'content',
    //     ];

    //     $model = new Task();
    //     $form = $this->factory->create(TaskType::class, $model);

    //     $expected = new Task();
    //     $expected->setTitle($formData['title']);
    //     $expected->setContent($formData['content']);

    //     $form->submit($formData);

    //     // This check ensures there are no transformation failures
    //     $this->assertTrue($form->isSynchronized());

    //     // check that $model was modified as expected when the form was submitted
    //     $this->assertEquals($expected->getTitle(), $model->getTitle());
    //     $this->assertEquals($expected->getContent(), $model->getContent());
    //     $this->assertEquals($expected->getAuthor(), $model->getAuthor());
    // }

    // public function testEditTask() 
    // {
    //     // $model = new Task();
    //     // $model->setId(0);
    //     // $model->setTitle('title');
    //     // $model->setContent('content');
    //     // $user = new User;

    //     // $model->setAuthor($user);
    //     // $form = $this->factory->create(TaskType::class, $model);

    //     // // This check ensures there are no transformation failures
    //     // $this->assertTrue($form->isSynchronized());

    //     // $model->setAuthor($user);

    //     // $form2 = $this->factory->create(TaskType::class, $model);

    //     // // This check ensures there are no transformation failures
    //     // $this->assertTrue($form2->isSynchronized());

        
    // }
}