<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Framework\Geocoder\Controller;

use Geocoder\Location;
use Geocoder\Model\Coordinates;
use Geocoder\Provider\Provider;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;
use SilvioKennecke\ClubEventCalendar\Administration\User\UserEntity;
use SilvioKennecke\ClubEventCalendar\Framework\Controller\AppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Service\Attribute\Required;

// TODO: check if geocoder is disabled

#[Route('/api/geocoder')]
class GeocoderController extends AppController
{
    private Provider $appGeocoder;

    #[Required]
    public function setAppGeocoder(Provider $appGeocoder): void
    {
        $this->appGeocoder = $appGeocoder;
    }

    #[Route('/address', name: 'app.geocoder.address', methods: ['GET'])]
    #[IsGranted(UserEntity::ROLE_USER)]
    public function geocodeAddress(Request $request): Response
    {
        $search = $request->query->getString('search');

        if (mb_strlen($search) < 5) {
            throw new BadRequestHttpException('Parameter search must have a minimum length of 5 characters');
        }

        $locations = $this->appGeocoder->geocodeQuery(GeocodeQuery::create($search));
        $coordinates = [];

        /** @var Location $location */
        foreach ($locations as $location) {
            $coordinate = $location->getCoordinates();
            if ($coordinate === null) {
                continue;
            }
            $coordinates[] = [
                'latitude' => $coordinate->getLatitude(),
                'longitude' => $coordinate->getLongitude(),
            ];
        }

        return new JsonResponse($coordinates);
    }

    #[Route('/reverse', name: 'app.geocoder.reverse', methods: ['GET'])]
    #[IsGranted(UserEntity::ROLE_USER)]
    public function geocodeReverse(Request $request): Response
    {
        $latitude = $request->query->get('latitude');
        $longitude = $request->query->get('longitude');

        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            throw new BadRequestHttpException('Parameters latitude and longitude must be of type float');
        }

        $locations = $this->appGeocoder->reverseQuery(
            ReverseQuery::create(
                new Coordinates((float) $latitude, (float) $longitude)
            )
        );
        $addresses = [];

        /** @var Location $location */
        foreach ($locations as $location) {
            $displayName = [
                [$location->getDetails()['tourism'] ?? $location->getDetails()['building'] ?? ''],
                [$location->getStreetName(), $location->getStreetNumber()],
                [$location->getPostalCode(), $location->getLocality()],
                [$location->getCountry()?->getName()],
            ];

            $displayName = array_filter(array_map('array_filter', $displayName));

            if ($displayName === []) {
                continue;
            }

            $displayName = implode(
                ', ',
                array_map(static fn(array $parts) => implode(' ', $parts), $displayName)
            );

            $addresses[] = $displayName;
        }

        return new JsonResponse($addresses);
    }
}
