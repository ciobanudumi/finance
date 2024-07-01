<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RecursiveTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecursiveTransactionRepository::class)]
#[ApiResource]
class RecursiveTransaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recursiveTransactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Transactions $transaction = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $nextOccurence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransaction(): ?Transactions
    {
        return $this->transaction;
    }

    public function setTransaction(?Transactions $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getNextOccurence(): ?\DateTimeImmutable
    {
        return $this->nextOccurence;
    }

    public function setNextOccurence(\DateTimeImmutable $nextOccurence): self
    {
        $this->nextOccurence = $nextOccurence;

        return $this;
    }
}
