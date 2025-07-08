<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Entity\Recipe;
use App\Entity\User;
use App\Port\Service\UserProviderInterface;

readonly class CreateRecipeUseCase
{
    public function __construct(private UserProviderInterface $userProvider)
    {
    }

    public function execute(Recipe $recipeInput): Recipe
    {
        $user = $this->userProvider->getCurrentUser();

        if (!$user instanceof User) {
            throw new \Exception('User not found');
        }

        $recipe = new Recipe();
        $recipe
            ->setTitle($recipeInput->getTitle())
            ->setDescription($recipeInput->getDescription())
            ->setDifficulty($recipeInput->getDifficulty())
            ->setOwner($user)
        ;

        return $recipe;
    }
}
