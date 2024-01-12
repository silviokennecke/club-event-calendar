<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\Feature;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use SilvioKennecke\ClubEventCalendar\Calendar\Event\EventTemplateEntity;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\EntityIdTrait;

#[ORM\Entity]
#[ORM\Table(name: 'feature')]
class FeatureEntity
{
    use EntityIdTrait;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: EventTemplateEntity::class, mappedBy: 'features')]
    private Collection $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }
}