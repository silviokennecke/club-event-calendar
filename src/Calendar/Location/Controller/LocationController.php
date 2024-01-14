<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\Location\Controller;

use Doctrine\ORM\EntityManagerInterface;
use SilvioKennecke\ClubEventCalendar\Administration\User\UserEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\Location\LocationEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\Location\Type\LocationType;
use SilvioKennecke\ClubEventCalendar\Framework\Controller\AppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/calendar/location')]
#[IsGranted(UserEntity::ROLE_USER)]
class LocationController extends AppController
{
    private EntityManagerInterface $entityManager;

    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app.calendar.location.index', methods: ['GET'])]
    public function list(): Response
    {
        $locations = $this->entityManager->getRepository(LocationEntity::class)
            ->createQueryBuilder('location')
            ->orderBy('location.name')
            ->getQuery()
            ->getArrayResult();

        $form = $this->createForm(LocationType::class, new LocationEntity(), [
            'method' => 'POST',
            'action' => $this->generateUrl('app.calendar.location.create'),
        ]);

        return $this->render('page/location/index.html.twig', [
            'locations' => $locations,
            'createForm' => $form,
        ]);
    }

    #[Route('/', name: 'app.calendar.location.create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $form = $this->createForm(LocationType::class, new LocationEntity());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $location = $form->getData();
            $this->entityManager->persist($location);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                $this->trans('app.calendar.locations.create.success', ['%name%' => $location->getName()])
            );
        } else {
            $this->addFlash(
                'danger',
                $this->trans('app.calendar.locations.create.error')
            );
        }

        return $this->redirectToRoute('app.calendar.location.index');
    }

    #[Route('/{id}', name: 'app.calendar.location.edit', methods: ['GET', 'POST'])]
    public function edit(LocationEntity $location, Request $request): Response
    {
        $form = $this->createForm(LocationType::class, $location);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $location = $form->getData();
                $this->entityManager->persist($location);
                $this->entityManager->flush();

                $this->addFlash(
                    'success',
                    $this->trans('app.calendar.locations.edit.success', ['%name%' => $location->getName()])
                );

                return $this->redirectToRoute('app.calendar.location.index');
            } else {
                $this->addFlash(
                    'danger',
                    $this->trans('app.calendar.locations.edit.error', ['%name%' => $location->getName()])
                );
            }
        }

        return $this->render('page/location/edit.html.twig', [
            'location' => $location,
            'editForm' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app.calendar.location.delete', methods: ['POST'])]
    #[IsGranted(UserEntity::ROLE_ADMIN)]
    public function delete(LocationEntity $location): Response
    {
        $this->entityManager->remove($location);
        $this->entityManager->flush();

        $this->addFlash(
            'success',
            $this->trans('app.calendar.locations.delete.success', ['%name%' => $location->getName()])
        );

        return $this->redirectToRoute('app.calendar.location.index');
    }
}
