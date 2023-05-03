<?php

namespace App\Entities\Patient;

use App\Entities\AbstractEntity;
use App\Repositories\Patient\PatientRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ORM\Table(name: 'patients')]
class Patient extends AbstractEntity
{
    #[ORM\Column(type: "string", length: 255, nullable: true)]
    protected ?string $firstName = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    protected ?string $lastName = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    protected ?string $middleName = null;

    #[ORM\Column(type: "string", length: 255)]
    protected string $snils;

    #[ORM\Column(type: "date", nullable: true)]
    protected ?DateTimeInterface $birthDate = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    protected ?string $residence = null;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    public function getSnils(): string
    {
        return $this->snils;
    }

    public function setSnils(string $snils): void
    {
        $this->snils = $snils;
    }

    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getResidence(): ?string
    {
        return $this->residence;
    }

    public function setResidence(?string $residence): void
    {
        $this->residence = $residence;
    }
}
