<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\TargetGroup\Type;

use SilvioKennecke\ClubEventCalendar\Calendar\TargetGroup\TargetGroupEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TargetGroupType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TargetGroupEntity::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'app.calendar.targetGroups.name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'app.general.save',
            ]);
    }
}
