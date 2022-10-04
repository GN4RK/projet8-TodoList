<?php

namespace App\Tests\Form;

use App\Form\TaskType;
use App\Entity\Task;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    // public function testSubmitValidDataTask() 
    // {
        // $formData = [
        //     'title' => 'title',
        //     'content' => 'content',
        // ];

        // $model = new Task();
        // $form = $this->factory->create(TaskType::class, $model);

        // $expected = new Task();
        // $expected->setTitle($formData['title']);
        // $expected->setContent($formData['content']);

        // $form->submit($formData);

        // // This check ensures there are no transformation failures
        // $this->assertTrue($form->isSynchronized());

        // // check that $model was modified as expected when the form was submitted
        // $this->assertEquals($expected, $model);


    // }
}