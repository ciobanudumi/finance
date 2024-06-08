<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTaskPatchDto extends CreateTaskDto
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    public string $pop;

    #[Assert\NotBlank]
    public int $row;

    #[Assert\NotBlank]
    public int $frame;

    #[Assert\NotBlank]
    #[Assert\Length(max: 1)]
    public string $block;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $trayFiber;

    #[Assert\NotBlank]
    public int $positionFiber;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $equipment;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $activePort;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $positionEquipment;

    #[Assert\NotBlank]
    public int $portingId;

    #[Assert\NotBlank]
    public int $rfTasksetId;

    #[Assert\Date]
    public ?string $registrationDate;
}