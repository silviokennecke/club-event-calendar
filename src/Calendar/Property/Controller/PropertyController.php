<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\Property\Controller;

use Doctrine\ORM\EntityManagerInterface;
use SilvioKennecke\ClubEventCalendar\Administration\User\UserEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\Property\PropertyEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\Property\Type\PropertyType;
use SilvioKennecke\ClubEventCalendar\Framework\Controller\AppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/calendar/property')]
#[IsGranted(UserEntity::ROLE_USER)]
class PropertyController extends AppController
{
    private EntityManagerInterface $entityManager;

    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app.calendar.property.index', methods: ['GET'])]
    public function list(): Response
    {
        $features = $this->entityManager->getRepository(PropertyEntity::class)
            ->createQueryBuilder('property')
            ->orderBy('property.name')
            ->getQuery()
            ->getArrayResult();

        $form = $this->createForm(PropertyType::class, new PropertyEntity(), [
            'method' => 'POST',
            'action' => $this->generateUrl('app.calendar.property.create'),
        ]);

        return $this->render('page/property/index.html.twig', [
            'properties' => $features,
            'createForm' => $form,
        ]);
    }

    #[Route('/', name: 'app.calendar.property.create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, new PropertyEntity());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $property = $form->getData();
            $this->entityManager->persist($property);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                $this->trans('app.calendar.properties.create.success', ['%name%' => $property->getName()])
            );
        } else {
            $this->addFlash(
                'danger',
                $this->trans('app.calendar.properties.create.error')
            );
        }

        return $this->redirectToRoute('app.calendar.property.index');
    }

    #[Route('/{id}', name: 'app.calendar.property.edit', methods: ['GET', 'POST'])]
    public function edit(PropertyEntity $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $property = $form->getData();
                $this->entityManager->persist($property);
                $this->entityManager->flush();

                $this->addFlash(
                    'success',
                    $this->trans('app.calendar.properties.edit.success', ['%name%' => $property->getName()])
                );

                return $this->redirectToRoute('app.calendar.property.index');
            } else {
                $this->addFlash(
                    'danger',
                    $this->trans('app.calendar.properties.edit.error', ['%name%' => $property->getName()])
                );
            }
        }

        return $this->render('page/property/edit.html.twig', [
            'property' => $property,
            'editForm' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app.calendar.property.delete', methods: ['POST'])]
    #[IsGranted(UserEntity::ROLE_ADMIN)]
    public function delete(PropertyEntity $feature): Response
    {
        $this->entityManager->remove($feature);
        $this->entityManager->flush();

        $this->addFlash(
            'success',
            $this->trans('app.calendar.properties.delete.success', ['%name%' => $feature->getName()])
        );

        return $this->redirectToRoute('app.calendar.property.index');
    }
}
