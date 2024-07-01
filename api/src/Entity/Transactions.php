<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TransactionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionsRepository::class)]
#[ApiResource]
class Transactions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $recursive = null;

    #[ORM\OneToMany(mappedBy: 'transaction', targetEntity: RecursiveTransaction::class)]
    private Collection $recursiveTransactions;

    public function __construct()
    {
        $this->recursiveTransactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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

    public function isRecursive(): ?bool
    {
        return $this->recursive;
    }

    public function setRecursive(?bool $recursive): self
    {
        $this->recursive = $recursive;

        return $this;
    }

    /**
     * @return Collection<int, RecursiveTransaction>
     */
    public function getRecursiveTransactions(): Collection
    {
        return $this->recursiveTransactions;
    }

    public function addRecursiveTransaction(RecursiveTransaction $recursiveTransaction): self
    {
        if (!$this->recursiveTransactions->contains($recursiveTransaction)) {
            $this->recursiveTransactions->add($recursiveTransaction);
            $recursiveTransaction->setTransaction($this);
        }

        return $this;
    }

    public function removeRecursiveTransaction(RecursiveTransaction $recursiveTransaction): self
    {
        if ($this->recursiveTransactions->removeElement($recursiveTransaction)) {
            // set the owning side to null (unless already changed)
            if ($recursiveTransaction->getTransaction() === $this) {
                $recursiveTransaction->setTransaction(null);
            }
        }

        return $this;
    }
}
