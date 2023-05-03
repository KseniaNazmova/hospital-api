<?php

namespace App\Entities\Doctor;

use App\Entities\AbstractEntity;
use App\Repositories\Doctor\DoctorRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctorRepository::class)]
#[ORM\Table(name: 'doctors')]
class Doctor extends AbstractEntity
{
    #[ORM\Column(type: "string", length: 255)]
    protected string $firstName;

    #[ORM\Column(type: "string", length: 255)]
    protected string $lastName;

    #[ORM\Column(type: "string", length: 20)]
    protected string $phone;

    #[ORM\Column(type: "time")]
    protected DateTimeInterface $workdayStart;

    #[ORM\Column(type: "time")]
    protected DateTimeInterface $workdayEnd;

    #[ORM\Column(type: "date", nullable: true)]
    protected ?DateTimeInterface $birthDate = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    protected ?string $middleName = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    protected ?string $email = null;

    // Getters
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getWorkdayStart(): DateTimeInterface
    {
        return $this->workdayStart;
    }

    public function getWorkdayEnd(): DateTimeInterface
    {
        return $this->workdayEnd;
    }

    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    // Setters
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setWorkdayStart(DateTimeInterface $workdayStart): void
    {
        $this->workdayStart = $workdayStart;
    }

    public function setWorkdayEnd(DateTimeInterface $workdayEnd): void
    {
        $this->workdayEnd = $workdayEnd;
    }

    public function setBirthDate(?DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
