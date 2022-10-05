<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'task_list')]
    public function list(ManagerRegistry $doctrine): Response
    {
        return $this->render('task/list.html.twig', ['tasks' => $doctrine->getRepository(Task::class)->findAll()]);
    }

    #[Route('/tasks/create', name: 'task_create')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $task->setAuthor($user);
            $em = $doctrine->getManager();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    public function edit(ManagerRegistry $doctrine, Task $task, Request $request): Response
    {
        // can the user edit this task ?
        $hasAccess = $this->isGranted('edit', $task);
        if (!$hasAccess) {
            $this->addFlash('error', 'Accès non authorisé.');
        }
        $this->denyAccessUnlessGranted('edit', $task);

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    public function toggleTask(ManagerRegistry $doctrine, Task $task): Response
    {
        // can the user toggle this task ?
        $hasAccess = $this->isGranted('toggle', $task);
        if (!$hasAccess) {
            $this->addFlash('error', 'Accès non authorisé.');
        }
        $this->denyAccessUnlessGranted('toggle', $task);

        $task->toggle(!$task->isDone());
        $doctrine->getManager()->flush();

        $state = $task->isDone() ? 'faite' : 'non terminée';
        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme %s.', $task->getTitle(), $state));

        return $this->redirectToRoute('task_list');
    }

    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    public function deleteTask(ManagerRegistry $doctrine, Task $task): Response
    {
        // can the user delete this task ?
        $hasAccess = $this->isGranted('delete', $task);
        if (!$hasAccess) {
            $this->addFlash('error', 'Accès non authorisé.');
        }
        $this->denyAccessUnlessGranted('delete', $task);

        $em = $doctrine->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
