<?php

namespace App\Tests\Form;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\Form\Test\TypeTestCase;

use function Amp\Promise\first;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidDataUser() 
    {
        $formData = [
            'username' => 'username',
            'password' => [
                'first' => 'password', 
                'second' => 'password'
            ],
            'email' => 'email@mail.com',
            'roles' => ['ROLE_USER']
        ];

        $model = new User();
        $form = $this->factory->create(UserType::class, $model);

        $expected = new User();
        $expected->setUsername($formData['username']);
        $expected->setPassword($formData['password']['first']);
        $expected->setEmail($formData['email']);
        $expected->setRoles($formData['roles']);
        

        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected->getUsername(), $model->getUsername());
        $this->assertEquals($expected->getRoles(), $model->getRoles());
        $this->assertEquals($expected->getPassword(), $model->getPassword());
        $this->assertEquals($expected->getEmail(), $model->getEmail());



        
    }
}