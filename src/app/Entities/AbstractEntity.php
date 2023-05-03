<?php

namespace App\Entities;

use App\Entities\Interfaces\PrePersistable;
use App\Entities\Traits\UuidTrait;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractEntity implements PrePersistable
{
    use UuidTrait;

    #[ORM\Column(type: "datetimetz_immutable")]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetimetz")]
    protected DateTime $updatedAt;

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function prePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
    }

    public function preUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }
}
