<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TaskTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskTypeRepository::class)]
#[ApiResource]
class TaskType
{
    public const TASK = 'task';
    public const TASK_PATCH_INSTALL = 'task_patch_install';
    public const TASK_PATCH_MIGRATE = 'task_patch_migrate';
    public const TASK_PATCH_REMOVE = 'task_patch_remove';
    public const TASK_ONSITE_INSTALLATION = 'task_onsite_installation';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: PortalCode::class, inversedBy: 'taskTypes')]
    private Collection $portalCodes;

    public function __construct()
    {
        $this->portalCodes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPortalCodes(): Collection
    {
        return $this->portalCodes;
    }

    /**
     * @param Collection $portalCodes
     * @return TaskType
     */
    public function setPortalCodes(Collection $portalCodes): TaskType
    {
        $this->portalCodes = $portalCodes;
        return $this;
    }

    public function addPortalCode(PortalCode $portalCode): self
    {
        if (!$this->portalCodes->contains($portalCode)) {
            $this->portalCodes->add($portalCode);
        }

        return $this;
    }

    public function removePortalCode(PortalCode $portalCode): self
    {
        $this->portalCodes->removeElement($portalCode);

        return $this;
    }
}
