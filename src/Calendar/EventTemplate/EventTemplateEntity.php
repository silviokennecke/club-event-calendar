<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\EventTemplate;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use SilvioKennecke\ClubEventCalendar\Calendar\Feature\FeatureEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\Location\LocationEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\Property\PropertyEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\TargetGroup\TargetGroupEntity;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\CreatedAtTrait;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\EntityIdTrait;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\UpdatedAtTrait;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'event_template')]
class EventTemplateEntity
{
    use EntityIdTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $name;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $eventName;

    #[ORM\Column(type: 'time', nullable: true)]
    private ?\DateTimeInterface $timeBegin;

    #[ORM\Column(type: 'time', nullable: true)]
    private ?\DateTimeInterface $timeEnd;

    #[ORM\ManyToMany(targetEntity: FeatureEntity::class, inversedBy: 'eventTemplates')]
    #[ORM\JoinTable(name: 'event_template_feature')]
    private Collection $features;

    #[ORM\ManyToMany(targetEntity: PropertyEntity::class, inversedBy: 'eventTemplates')]
    #[ORM\JoinTable(name: 'event_template_property')]
    private Collection $properties;

    #[ORM\ManyToMany(targetEntity: TargetGroupEntity::class, inversedBy: 'eventTemplates')]
    #[ORM\JoinTable(name: 'event_template_target_group')]
    private Collection $targetGroups;

    #[ORM\ManyToOne(targetEntity: LocationEntity::class, inversedBy: 'eventTemplates')]
    private ?LocationEntity $location = null;

    public function __construct()
    {
        $this->features = new ArrayCollection();
        $this->properties = new ArrayCollection();
        $this->targetGroups = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): void
    {
        $this->eventName = $eventName;
    }

    public function getTimeBegin(): ?\DateTimeInterface
    {
        return $this->timeBegin;
    }

    public function setTimeBegin(?\DateTimeInterface $timeBegin): void
    {
        $this->timeBegin = $timeBegin;
    }

    public function getTimeEnd(): ?\DateTimeInterface
    {
        return $this->timeEnd;
    }

    public function setTimeEnd(?\DateTimeInterface $timeEnd): void
    {
        $this->timeEnd = $timeEnd;
    }

    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function setFeatures(Collection $features): void
    {
        $this->features = $features;
    }

    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function setProperties(Collection $properties): void
    {
        $this->properties = $properties;
    }

    public function getTargetGroups(): Collection
    {
        return $this->targetGroups;
    }

    public function setTargetGroups(Collection $targetGroups): void
    {
        $this->targetGroups = $targetGroups;
    }

    public function getLocation(): ?LocationEntity
    {
        return $this->location;
    }

    public function setLocation(?LocationEntity $location): void
    {
        $this->location = $location;
    }
}
