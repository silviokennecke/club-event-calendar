<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Framework\ORM;

use Doctrine\ORM\Mapping as ORM;

trait UpdatedAtTrait
{
    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $updatedAt;

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setCreatedAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}