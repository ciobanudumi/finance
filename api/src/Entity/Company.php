<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[Gedmo\SoftDeleteable()]
#[ApiResource]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;
    #[ORM\Column]
    private ?bool $administrativeDisabled = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Task::class)]
    private Collection $tasks;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: MatchingCriteria::class)]
    private Collection $matchingCriterias;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'companies')]
    private Collection $users;

    #[ORM\Column(name: 'deletedAt', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $deletedAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $fiberCrewId  = null;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->matchingCriterias = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function isAdministrativeDisabled(): ?bool
    {
        return $this->administrativeDisabled;
    }

    public function setAdministrativeDisabled(bool $administrativeDisabled): self
    {
        $this->administrativeDisabled = $administrativeDisabled;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setCompany   ($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getCompany() === $this) {
                $task->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MatchingCriteria>
     */
    public function getMatchingCriterias(): Collection
    {
        return $this->matchingCriterias;
    }

    public function addMatchingCriteria(MatchingCriteria $matchingCriteria): self
    {
        if (!$this->matchingCriterias->contains($matchingCriteria)) {
            $this->matchingCriterias->add($matchingCriteria);
            $matchingCriteria->setCompany($this);
        }

        return $this;
    }

    public function removeMatchingCriteria(MatchingCriteria $matchingCriteria): self
    {
        if ($this->matchingCriterias->removeElement($matchingCriteria)) {
            // set the owning side to null (unless already changed)
            if ($matchingCriteria->getCompany() === $this) {
                $matchingCriteria->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCompany($this);
        }

        return $this;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return int|null
     */
    public function getFiberCrewId(): ?int
    {
        return $this->fiberCrewId;
    }

    /**
     * @param int|null $fiberCrewId
     * @return Company
     */
    public function setFiberCrewId(?int $fiberCrewId): self
    {
        $this->fiberCrewId = $fiberCrewId;
        return $this;
    }

}
