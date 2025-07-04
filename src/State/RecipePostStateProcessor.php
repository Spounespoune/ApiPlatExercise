<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Recipe;
use App\UseCases\CreateRecipeUseCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

readonly class RecipePostStateProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CreateRecipeUseCase $createRecipeUseCase,
        private ProcessorInterface $persistProcessor,
    )
    {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Recipe
    {
        if (!$operation instanceof Post) {
            return $data;
        }

        $data = $this->createRecipeUseCase->execute($data);

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
