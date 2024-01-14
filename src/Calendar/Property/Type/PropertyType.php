<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\Property\Type;

use SilvioKennecke\ClubEventCalendar\Calendar\Property\PropertyEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropertyEntity::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('icon', TextType::class, [
                'label' => 'app.calendar.properties.icon',
            ])
            ->add('name', TextType::class, [
                'label' => 'app.calendar.properties.name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'app.general.save',
            ]);
    }
}
