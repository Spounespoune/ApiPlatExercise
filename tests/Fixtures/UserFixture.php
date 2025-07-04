<?php

namespace Fixtures;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DependencyInjection\Container;

class UserFixture implements FixtureInterface
{
    public function __construct(private User $user)
    {
    }

    public function load(Container $container): void
    {
        $clearPassword = $this->user->getPassword();
        $hashPassword = password_hash($clearPassword, PASSWORD_DEFAULT);

        $this->user->setPassword($hashPassword);

        $entityManager = $container->get('doctrine.orm.entity_manager');
        $entityManager->persist($this->user);
    }

    public function authenticate(KernelBrowser $browser): void
    {
        $browser->loginUser($this->user);
    }
}
