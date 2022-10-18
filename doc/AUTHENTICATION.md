# Guide général sur l'authentification de l'application

Un utilisateur est représenté par l'entité User de l'application. L'utilisateur est identifié avec son username. Ces paramètres sont configurés dans le fichier config/packages/security.yaml

```yaml
# config/packages/security.yaml
security:
    providers:
        app_user_provider:
            entity:
                class: 'App\Entity\User'
                property: 'username'
```

Il y a une contrainte d'unicité sur le nom d'utilisateur et sur l'email

```php
// src/Entity/User.php
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity("username", message: "Ce nom d'utilisateur est déjà utilisé.")]
#[UniqueEntity("email", message: "Cet email est déjà utilisé.")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
```

L'accès aux pages d'administration est géré avec les ROLES des utilisateurs.
Exemple : 
```php
// src/Controller/UserController.php
$hasAccess = $this->isGranted('ROLE_ADMIN');
if (!$hasAccess) {
    $this->addFlash('error', 'Accès non authorisé.');
}
$this->denyAccessUnlessGranted('ROLE_ADMIN');
```

Pour les autres pages et fonctionnalités, leurs accès sont gérés avec les Voters de symfony.
Exemple : 
```php
// src/Controller/TaskController.php
#[Route('/tasks/create', name: 'task_create')]
public function create(ManagerRegistry $doctrine, Request $request): Response
{
    $task = new Task();

    // can the user create a task ?
    $hasAccess = $this->isGranted('create', $task);
    if (!$hasAccess) {
        $this->addFlash('error', 'Accès non authorisé.');
    }
    $this->denyAccessUnlessGranted('create', $task);

```


```php
// src/Security/TaskVoter.php
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
```


