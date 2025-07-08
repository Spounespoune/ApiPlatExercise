<?php

declare(strict_types=1);

namespace App\Infrastructure\ForProduction;

use App\Entity\User;
use App\Port\Service\UserProviderInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class SymfonyUserProvider implements UserProviderInterface
{
    public function __construct(private Security $security)
    {
    }

    public function getCurrentUser(): ?UserInterface
    {
        $user = $this->security->getUser();

        if (!($user instanceof User)) {
            throw new \Exception('User is not an instance of User');
        }

        return $user;
    }
}
