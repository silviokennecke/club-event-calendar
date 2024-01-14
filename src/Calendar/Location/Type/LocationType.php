<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\Location\Type;

use SilvioKennecke\ClubEventCalendar\Calendar\Location\LocationEntity;
use SilvioKennecke\ClubEventCalendar\Framework\Type\MapType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LocationEntity::class,
            'attr' => [
                'data-controller' => 'map-form',
            ],
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'app.calendar.locations.name',
            ])
            ->add('address', TextType::class, [
                'label' => 'app.calendar.locations.address',
                'attr' => [
                    'data-map-form-target' => 'address',
                ],
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'app.calendar.locations.latitude',
                'scale' => 6,
                'attr' => [
                    'data-map-form-target' => 'latitude',
                ],
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'app.calendar.locations.longitude',
                'scale' => 6,
                'attr' => [
                    'data-map-form-target' => 'longitude',
                ],
            ])
            ->add('map', MapType::class)
            ->add('save', SubmitType::class, [
                'label' => 'app.general.save',
            ]);
    }
}
