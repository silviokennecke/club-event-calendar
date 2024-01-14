<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Framework\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MapType extends AbstractType implements DataTransformerInterface
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data' => [
                'addressGeocoderRoute' => 'app.geocoder.address',
                'reverseGeocoderRoute' => 'app.geocoder.reverse',
            ],
        ]);
    }

    public function getBlockPrefix()
    {
        return 'map';
    }

    public function transform(mixed $data): mixed
    {
        return $data;
    }

    public function reverseTransform(mixed $value): mixed
    {
        return $data ?? '';
    }
}
