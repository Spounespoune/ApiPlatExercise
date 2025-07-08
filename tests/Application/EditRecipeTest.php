<?php

declare(strict_types=1);

namespace App\Tests\Application;

use App\Entity\Recipe;
use App\Entity\User;
use App\Enum\RecipeSkillLevel;
use App\Repository\RecipeRepository;
use App\Tests\Fixtures\RecipeFixture;
use Fixtures\UserFixture;
use Infrastructure\ApplicationTestCase;

class EditRecipeTest extends ApplicationTestCase
{
    private UserFixture $userFixture;

    public function setUp(): void
    {
        self::initialize();

        $user = new User();
        $user
            ->setEmail('owner@localhost')
            ->setPassword('password');

        $recipe = new Recipe();
        $recipe
            ->setTitle('Test recipe')
            ->setDescription('<DESCRIPTION>')
            ->setDifficulty(RecipeSkillLevel::EASY)
            ->setOwner($user)
        ;

        $this->userFixture = new UserFixture($user);
        $recipeFixture = new RecipeFixture($recipe);

        $fixture = [
            $this->userFixture,
            $recipeFixture,
        ];

        $this->loadFixtures($fixture);
    }

    public function testUpdateRecipeWithOwner(): void
    {
        $this->userFixture->authenticate(self::$client);

        $content = json_encode([
            'title' => 'Test recipe',
            'description' => 'EDIT : Une délicieuse recette de test',
            'difficulty' => RecipeSkillLevel::MEDIUM->value,
        ]);

        self::$client->request(
            'PUT',
            '/api/recipes/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/ld+json'],
            $content
        );

        $this->assertResponseStatusCodeSame(200);

        $recipeRepository = self::$client->getContainer()->get(RecipeRepository::class);
        $recipe = $recipeRepository->find(1);

        $this->assertNotNull($recipe);

        $this->assertEquals('EDIT : Une délicieuse recette de test', $recipe->getDescription());
        $this->assertEquals(RecipeSkillLevel::MEDIUM, $recipe->getDifficulty());
    }
}
