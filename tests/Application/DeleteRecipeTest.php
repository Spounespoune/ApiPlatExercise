<?php

declare(strict_types=1);

namespace App\Tests\Application;

use App\Entity\Recipe;
use App\Entity\User;
use App\Enum\RecipeSkillLevel;
use App\Tests\Fixtures\RecipeFixture;
use Fixtures\UserFixture;
use Infrastructure\ApplicationTestCase;

class DeleteRecipeTest extends ApplicationTestCase
{
    private UserFixture $ownerFixture;
    private UserFixture $otherUserFixture;

    public function setUp(): void
    {
        self::initialize();

        $owner = new User();
        $owner
            ->setEmail('owner@localhost')
            ->setPassword('password');

        $this->ownerFixture = new UserFixture($owner);

        $this->otherUserFixture = new UserFixture(
            new User()
                ->setEmail('other@localhost')
                ->setPassword('password')
        );

        $recipe = new Recipe();
        $recipe
            ->setTitle('Test recipe hard')
            ->setDescription('<DESCRIPTION>')
            ->setDifficulty(RecipeSkillLevel::EASY)
            ->setOwner($owner)
        ;

        $recipeFixture = new RecipeFixture($recipe);

        $fixture = [
            $this->ownerFixture,
            $recipeFixture,
        ];

        $this->loadFixtures($fixture);
    }

    public function testDeleteRecipe(): void
    {
        $this->ownerFixture->authenticate(self::$client);

        self::$client->request(
            'DELETE',
            '/api/recipes/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertResponseStatusCodeSame(204);
    }

    public function testDeleteRecipeWhenIsNotOwner(): void
    {
        $this->otherUserFixture->authenticate(self::$client);

        self::$client->request(
            'DELETE',
            '/api/recipes/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertResponseStatusCodeSame(403);
    }
}
