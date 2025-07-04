<?php

declare(strict_types=1);

namespace App\Dto\Input\Recipe;

use App\Enum\RecipeSkillLevel;
use Symfony\Component\Validator\Constraints as Assert;

class CreateRecipeInput
{
    #[Assert\NotBlank]
    private ?string $title = null;

    private ?string $description = null;

    #[Assert\NotNull]
    private ?RecipeSkillLevel $difficulty = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDifficulty(): ?RecipeSkillLevel
    {
        return $this->difficulty;
    }

    public function setDifficulty(?RecipeSkillLevel $difficulty): CreateRecipeInput
    {
        $this->difficulty = $difficulty;
        return $this;
    }
}
