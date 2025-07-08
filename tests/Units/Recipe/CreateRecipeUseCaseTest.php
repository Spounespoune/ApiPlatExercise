<?php

declare(strict_types=1);

namespace App\Tests\Units\Recipe;

use App\Entity\Recipe;
use App\Entity\User;
use App\Enum\RecipeSkillLevel;
use App\Infrastructure\ForTest\FixedUserProvider;
use App\UseCases\CreateRecipeUseCase;
use PHPUnit\Framework\TestCase;

class CreateRecipeUseCaseTest extends TestCase
{
    public function testCreateRecipe(): void
    {
        $owner = User::create(1, '<EMAIL>', '<PASSWORD>');
        $userProvider = new FixedUserProvider($owner);

        $recipeInput = new Recipe();
        $recipeInput
            ->setTitle('title')
            ->setDescription('description')
            ->setDifficulty(RecipeSkillLevel::EASY)
        ;

        $createRecipeUseCase = new CreateRecipeUseCase($userProvider);
        $recipe = $createRecipeUseCase->execute($recipeInput);

        $this->assertEquals('title', $recipe->getTitle());
        $this->assertEquals('description', $recipe->getDescription());
        $this->assertEquals(RecipeSkillLevel::EASY, $recipe->getDifficulty());
        $this->assertEquals($owner->getId(), $recipe->getOwner()->getId());
    }
}
