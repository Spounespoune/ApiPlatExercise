<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Entity\Recipe;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

readonly class EditRecipeUseCase
{
    public function __construct(private Security $security)
    {
    }

    public function execute(Recipe $recipeInput): Recipe
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new \Exception('User not found');
        }

        $recipeInput->setOwner($user);

        return $recipeInput;
    }
}
