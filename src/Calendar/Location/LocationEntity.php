<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\Location;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use SilvioKennecke\ClubEventCalendar\Calendar\Event\EventEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\EventTemplate\EventTemplateEntity;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\CreatedAtTrait;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\EntityIdTrait;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\UpdatedAtTrait;
use Symfony\Component\Validator\Constraints;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'location')]
class LocationEntity
{
    use EntityIdTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $address;

    #[Constraints\GreaterThanOrEqual(-90)]
    #[Constraints\LessThanOrEqual(90)]
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $latitude;

    #[Constraints\GreaterThanOrEqual(-180)]
    #[Constraints\LessThanOrEqual(180)]
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $longitude;

    /**
     * @var mixed|null This is just a dummy for the LocationType
     */
    public $map = null;

    #[ORM\OneToMany(targetEntity: EventEntity::class, mappedBy: 'location')]
    private Collection $events;

    #[ORM\OneToMany(targetEntity: EventTemplateEntity::class, mappedBy: 'location')]
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
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
