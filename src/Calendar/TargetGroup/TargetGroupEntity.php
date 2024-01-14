<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\TargetGroup;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use SilvioKennecke\ClubEventCalendar\Calendar\Event\EventEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\EventTemplate\EventTemplateEntity;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\CreatedAtTrait;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\EntityIdTrait;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\UpdatedAtTrait;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'target_group')]
class TargetGroupEntity
{
    use EntityIdTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: EventEntity::class, mappedBy: 'targetGroups')]
    private Collection $events;

    #[ORM\ManyToMany(targetEntity: EventTemplateEntity::class, mappedBy: 'targetGroups')]
    private Collection $eventTemplates;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function setEvents(Collection $events): void
    {
        $this->events = $events;
    }

    public function getEventTemplates(): Collection
    {
        return $this->eventTemplates;
    }

    public function setEventTemplates(Collection $eventTemplates): void
    {
        $this->eventTemplates = $eventTemplates;
    }
}
