<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Recipe;
use App\UseCases\EditRecipeUseCase;

readonly class RecipePutStateProcessor implements ProcessorInterface
{
    public function __construct(
        private EditRecipeUseCase $editRecipeUseCase,
        private ProcessorInterface $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Recipe
    {
        if (!$operation instanceof Put) {
            return $data;
        }

        $data = $this->editRecipeUseCase->execute($data);

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
