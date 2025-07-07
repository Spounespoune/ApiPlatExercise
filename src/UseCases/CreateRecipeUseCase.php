<?php

declare(strict_types=1);

namespace App\UseCases;

use App\Entity\Recipe;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

readonly class CreateRecipeUseCase
{
    public function __construct(private Security $security)
    {
    }

    public function execute(Recipe $recipeInput): Recipe
    {
        $user = $this->security->getUser();

        if (!$user || !$user instanceof User) {
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
