<?php

namespace App\Security;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';
    const TOGGLE = 'toggle';
    const CREATE = 'create';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::EDIT, self::DELETE, self::TOGGLE, self::CREATE])) {
            return false;
        }

        // only vote on `Task` objects
        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            // this condition filter if the user can toggle a task
            return false;
        }

        // ROLE_ADMIN can do anything
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        // you know $subject is a Task object, thanks to `supports()`
        /** @var Task $task */
        $task = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($task, $user);
            case self::DELETE:
                return $this->canDelete($task, $user);
            case self::TOGGLE:
            case self::CREATE:
                return true; // filtered above with "if (!$user instanceof User)"
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Task $task, User $user): bool
    {
        return $user === $task->getAuthor();
    }

    private function canDelete(Task $task, User $user): bool
    {
        return $user === $task->getAuthor();
    }
}