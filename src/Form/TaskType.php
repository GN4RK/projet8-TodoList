<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TaskType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content', TextareaType::class)
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $task = $event->getData();
            $form = $event->getForm();

            if (!$task || null === $task->getId()) {
                // new task
                $author = ($this->security->getUser() != null) ? $this->security->getUser()->getUsername() : null;
                $form->add('author', TextType::class, [
                    'disabled' => 'true',
                    'data' => $author
                ]);

            } else {
                // edit task
                if ($task->getAuthor()->getId() == 0) {
                    $form->add('author', TextType::class, [
                        'data' => 'Anonyme',
                        'disabled' => 'true'
                    ]);
                } else {
                    $form->add('author', EntityType::class, [
                        'class' => User::class,
                        'choice_label' => 'username',
                        'disabled' => 'true'
                    ]);
                }
            }
        });
    }
}
