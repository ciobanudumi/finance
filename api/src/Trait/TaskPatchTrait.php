<?php

namespace App\Trait;

use App\Doctrine\Annotation\SyncMerge as Merge;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait TaskPatchTrait
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Merge]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\Column]
    #[Merge]
    private ?int $rfTasksetId = null;

    #[ORM\Column(length: 50)]
    #[Merge]
    private ?string $pop = null;

    #[ORM\Column]
    #[Merge]
    private ?int $row = null;

    #[ORM\Column]
    #[Merge]
    private ?int $frame = null;

    #[ORM\Column(length: 1)]
    #[Merge]
    private ?string $block = null;

    #[ORM\Column(length: 100)]
    #[Merge]
    private ?string $trayFiber = null;

    #[ORM\Column]
    #[Merge]
    private ?int $positionFiber = null;

    #[ORM\Column]
    #[Merge]
    private ?int $portingId = null;

    #[ORM\Column(length: 100)]
    #[Merge]
    private ?string $equipment = null;

    #[ORM\Column(length: 100)]
    #[Merge]
    private ?string $activePort = null;

    #[ORM\Column(length: 100)]
    #[Merge]
    private ?string $positionEquipment = null;

    /**
     * @return \DateTimeInterface|null
     */
    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    /**
     * @param \DateTimeInterface|null $registrationDate
     */
    public function setRegistrationDate(?\DateTimeInterface $registrationDate): void
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return int|null
     */
    public function getRfTasksetId(): ?int
    {
        return $this->rfTasksetId;
    }

    /**
     * @param int|null $rfTasksetId
     */
    public function setRfTasksetId(?int $rfTasksetId): void
    {
        $this->rfTasksetId = $rfTasksetId;
    }

    public function getPop(): ?string
    {
        return $this->pop;
    }

    public function setPop(string $pop): self
    {
        $this->pop = $pop;

        return $this;
    }

    public function getRow(): ?int
    {
        return $this->row;
    }

    public function setRow(int $row): self
    {
        $this->row = $row;

        return $this;
    }

    public function getFrame(): ?int
    {
        return $this->frame;
    }

    public function setFrame(int $frame): self
    {
        $this->frame = $frame;

        return $this;
    }

    public function getBlock(): ?string
    {
        return $this->block;
    }

    public function setBlock(string $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getTrayFiber(): ?string
    {
        return $this->trayFiber;
    }

    public function setTrayFiber(string $trayFiber): self
    {
        $this->trayFiber = $trayFiber;

        return $this;
    }

    public function getPositionFiber(): ?int
    {
        return $this->positionFiber;
    }

    public function setPositionFiber(int $positionFiber): self
    {
        $this->positionFiber = $positionFiber;

        return $this;
    }

    public function getPortingId(): ?int
    {
        return $this->portingId;
    }

    public function setPortingId(int $portingId): self
    {
        $this->portingId = $portingId;

        return $this;
    }

    public function getEquipment(): ?string
    {
        return $this->equipment;
    }

    public function setEquipment(string $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getActivePort(): ?string
    {
        return $this->activePort;
    }

    public function setActivePort(string $activePort): self
    {
        $this->activePort = $activePort;

        return $this;
    }

    public function getPositionEquipment(): ?string
    {
        return $this->positionEquipment;
    }

    public function setPositionEquipment(string $positionEquipment): self
    {
        $this->positionEquipment = $positionEquipment;

        return $this;
    }
}