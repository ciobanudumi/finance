<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\DBAL\Types\Types;
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_INTERNAL = 'ROLE_INTERNAL';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_TASK_SET_OPERATIONS = 'ROLE_TASK_SET_OPERATIONS';
    public const ROLE_TASK_OPERATIONS = 'ROLE_TASK_OPERATIONS';
    public const ROLE_ENGINEER = 'ROLE_ENGINEER';

    public const ALLOWED_ROLES = [
        self::ROLE_INTERNAL,
        self::ROLE_ADMIN,
        self::ROLE_TASK_SET_OPERATIONS,
        self::ROLE_TASK_OPERATIONS,
        self::ROLE_ENGINEER,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: false)]
    private ?string $name = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(name: 'deletedAt', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $deletedAt;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'assignee', targetEntity: TaskSet::class)]
    private Collection $taskSets;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MatchingCriteria::class)]
    private Collection $matchingCriterias;

    #[Assert\Count(min: 1)]
    #[ORM\ManyToMany(targetEntity: Company::class, inversedBy: 'users')]
    private Collection $companies;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'preferred_executor', targetEntity: Task::class)]
    private Collection $preferredExecutorTasks;

    public function __construct()
    {
        $this->taskSets = new ArrayCollection();
        $this->matchingCriterias = new ArrayCollection();
        $this->companies = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(#[\SensitiveParameter] string $password): self
    {
        $this->password = $password;

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
     * @see UserInterface
     */
    public function eraseCredentials():void
    {
    }

    /**
     * @return Collection<int, TaskSet>
     */
    public function getTaskSets(): Collection
    {
        return $this->taskSets;
    }

    public function addTaskSet(TaskSet $taskSet): self
    {
        if (!$this->taskSets->contains($taskSet)) {
            $this->taskSets->add($taskSet);
            $taskSet->setAssignee($this);
        }

        return $this;
    }

    public function removeTaskSet(TaskSet $taskSet): self
    {
        if ($this->taskSets->removeElement($taskSet)) {
            // set the owning side to null (unless already changed)
            if ($taskSet->getAssignee() === $this) {
                $taskSet->setAssignee(null);
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
            $matchingCriteria->setUser($this);
        }

        return $this;
    }

    public function removeMatchingCriteria(MatchingCriteria $matchingCriteria): self
    {
        if ($this->matchingCriterias->removeElement($matchingCriteria)) {
            // set the owning side to null (unless already changed)
            if ($matchingCriteria->getUser() === $this) {
                $matchingCriteria->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        $this->companies->removeElement($company);

        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPreferredExecutorTasks(): Collection
    {
        return $this->preferredExecutorTasks;
    }

    public function setPreferredExecutorTasks(Collection $preferredExecutorTasks): void
    {
        $this->preferredExecutorTasks = $preferredExecutorTasks;
    }
}
