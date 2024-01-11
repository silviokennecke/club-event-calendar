<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Framework\ORM;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

trait EntityIdTrait
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    protected ?Uuid $id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }
}