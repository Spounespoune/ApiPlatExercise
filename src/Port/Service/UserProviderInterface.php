<?php

declare(strict_types=1);

namespace App\Port\Service;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserProviderInterface
{
    public function getCurrentUser(): ?UserInterface;
}
