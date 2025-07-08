<?php

declare(strict_types=1);

namespace App\Infrastructure\ForTest;

use App\Port\Service\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class FixedUserProvider implements UserProviderInterface
{
    public function __construct(private UserInterface $user)
    {
    }

    public function getCurrentUser(): ?UserInterface
    {
        return $this->user;
    }
}
