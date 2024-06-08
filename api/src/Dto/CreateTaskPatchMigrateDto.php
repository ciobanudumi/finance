<?php
declare(strict_types=1);


namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTaskPatchMigrateDto extends CreateTaskPatchDto
{
    #[Assert\NotBlank]
    public int $patchcordLength;

    #[Assert\NotBlank]
    public int $patchcordThickness;
}