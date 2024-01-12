<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use SilvioKennecke\ClubEventCalendar\Calendar\Feature\FeatureEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\Location\LocationEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\Property\PropertyEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\TargetGroup\TargetGroupEntity;
use SilvioKennecke\ClubEventCalendar\Framework\ORM\EntityIdTrait;

#[ORM\Entity]
#[ORM\Table(name: 'event_template')]
class EventTemplateEntity
{
    use EntityIdTrait;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $name;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $eventName;

    #[ORM\Column(type: 'time', nullable: true)]
    private ?\DateTimeInterface $timeBegin;

    #[ORM\Column(type: 'time', nullable: true)]
    private ?\DateTimeInterface $timeEnd;

    #[ORM\ManyToMany(targetEntity: FeatureEntity::class, inversedBy: 'events')]
    #[ORM\JoinTable(name: 'event_template_feature')]
    private Collection $features;

    #[ORM\ManyToMany(targetEntity: PropertyEntity::class, inversedBy: 'events')]
    #[ORM\JoinTable(name: 'event_template_property')]
    private Collection $properties;

    #[ORM\ManyToMany(targetEntity: TargetGroupEntity::class, inversedBy: 'events')]
    #[ORM\JoinTable(name: 'event_template_target_group')]
    private Collection $targetGroups;

    #[ORM\ManyToOne(targetEntity: LocationEntity::class, inversedBy: 'events')]
    private ?LocationEntity $location = null;

    public function __construct()
    {
        $this->features = new ArrayCollection();
        $this->properties = new ArrayCollection();
        $this->targetGroups = new ArrayCollection();
    }
}
