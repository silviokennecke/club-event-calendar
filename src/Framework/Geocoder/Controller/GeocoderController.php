<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Framework\Geocoder\Controller;

use Geocoder\Provider\Provider;
use Geocoder\Query\GeocodeQuery;
use SilvioKennecke\ClubEventCalendar\Administration\User\UserEntity;
use SilvioKennecke\ClubEventCalendar\Framework\Controller\AppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Service\Attribute\Required;

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

        foreach ($locations as $location) {
            $coordinate = $location->getCoordinates();
            if ($coordinate === null) {
                continue;
            }
            $coordinates[] = $coordinate->toArray();
        }

        return new JsonResponse($coordinates);
    }
}
