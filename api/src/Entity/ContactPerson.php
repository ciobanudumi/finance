<?php

namespace App\Entity;

use App\Doctrine\Annotation\SyncMerge as Merge;
use App\Repository\ContactPersonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactPersonRepository::class)]
class ContactPerson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: false)]
    #[Merge]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Merge]
    private ?string $street = null;

    #[ORM\Column(length: 6, nullable: false)]
    #[Merge]
    private ?string $zipcode = null;

    #[ORM\Column(type: 'integer', nullable: false)]
    #[Merge]
    private ?int $houseNumber = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Merge]
    private ?string $houseNumberExtension = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Merge]
    private ?int $roomNumber = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Merge]
    private ?string $city = null;

    #[ORM\Column(length: 15, nullable: false)]
    #[Merge]
    private ?string $phoneNumber;

    #[ORM\Column(length: 15, nullable: false)]
    #[Merge]
    private ?string $mobileNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Merge]
    private ?string $emailAddress = null;

    #[ORM\Column(nullable: true)]
    #[Merge]
    private ?string $notes = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     */
    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string|null
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    /**
     * @param string|null $zipcode
     */
    public function setZipcode(?string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return int|null
     */
    public function getHouseNumber(): ?int
    {
        return $this->houseNumber;
    }

    /**
     * @param int|null $houseNumber
     */
    public function setHouseNumber(?int $houseNumber): void
    {
        $this->houseNumber = $houseNumber;
    }

    /**
     * @return string|null
     */
    public function getHouseNumberExtension(): ?string
    {
        return $this->houseNumberExtension;
    }

    /**
     * @param string|null $houseNumberExtension
     */
    public function setHouseNumberExtension(?string $houseNumberExtension): void
    {
        $this->houseNumberExtension = $houseNumberExtension;
    }

    /**
     * @return int|null
     */
    public function getRoomNumber(): ?int
    {
        return $this->roomNumber;
    }

    /**
     * @param int|null $roomNumber
     */
    public function setRoomNumber(?int $roomNumber): void
    {
        $this->roomNumber = $roomNumber;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    /**
     * @param string|null $mobileNumber
     */
    public function setMobileNumber(?string $mobileNumber): void
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return string|null
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    /**
     * @param string|null $emailAddress
     */
    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     */
    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

}