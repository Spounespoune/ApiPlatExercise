<?php

declare(strict_types=1);

namespace Application;

use App\Entity\User;
use App\Repository\RecipeRepository;
use Fixtures\UserFixture;
use Infrastructure\ApplicationTestCase;

class CreateRecipeTest extends ApplicationTestCase
{
    private UserFixture $userFixture;

    public function setUp(): void
    {
        self::initialize();

        $user = new User();
        $user
            ->setEmail('owner@localhost')
            ->setPassword('password');

        $this->userFixture = new UserFixture($user);

        $fixture = [
            $this->userFixture,
        ];

        $this->loadFixtures($fixture);
    }

    public function testCreateRecipeNotAllowedWithoutAuthentication(): void
    {
        self::$client->request(
            'POST',
            '/api/recipes',
            [],
            [],
            ['CONTENT_TYPE' => 'application/ld+json'],
            '{"name": "Test recipe"}'
        );

        $this->assertResponseStatusCodeSame(401);
    }

    public function testCreateRecipe(): void
    {
        $this->userFixture->authenticate(self::$client);

        $content = json_encode([
            'title' => 'Test recipe',
            'description' => 'Une délicieuse recette de test',
            'difficulty' => 'easy',
        ]);

        self::$client->request(
            'POST',
            '/api/recipes',
            [],
            [],
            ['CONTENT_TYPE' => 'application/ld+json'],
            $content
        );

        $this->assertResponseStatusCodeSame(201);

        $recipeRepository = self::$client->getContainer()->get(RecipeRepository::class);
        $recipe = $recipeRepository->findOneBy(['title' => 'Test recipe']);

        $this->assertNotNull($recipe);
    }
}
