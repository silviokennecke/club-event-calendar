<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\Feature\Type;

use SilvioKennecke\ClubEventCalendar\Calendar\Feature\FeatureEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeatureType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FeatureEntity::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'app.calendar.features.name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'app.general.save',
            ]);
    }
}
