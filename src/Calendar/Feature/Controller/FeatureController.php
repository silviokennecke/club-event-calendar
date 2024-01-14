<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\Feature\Controller;

use Doctrine\ORM\EntityManagerInterface;
use SilvioKennecke\ClubEventCalendar\Administration\User\UserEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\Feature\FeatureEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\Feature\Type\FeatureType;
use SilvioKennecke\ClubEventCalendar\Framework\Controller\AppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/calendar/feature')]
#[IsGranted(UserEntity::ROLE_USER)]
class FeatureController extends AppController
{
    private EntityManagerInterface $entityManager;

    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app.calendar.feature.index', methods: ['GET'])]
    public function list(): Response
    {
        $features = $this->entityManager->getRepository(FeatureEntity::class)
            ->createQueryBuilder('feature')
            ->orderBy('feature.name')
            ->getQuery()
            ->getArrayResult();

        $form = $this->createForm(FeatureType::class, new FeatureEntity(), [
            'method' => 'POST',
            'action' => $this->generateUrl('app.calendar.feature.create'),
        ]);

        return $this->render('page/feature/index.html.twig', [
            'features' => $features,
            'createForm' => $form,
        ]);
    }

    #[Route('/', name: 'app.calendar.feature.create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $form = $this->createForm(FeatureType::class, new FeatureEntity());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $feature = $form->getData();
            $this->entityManager->persist($feature);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                $this->trans('app.calendar.features.create.success', ['%name%' => $feature->getName()])
            );
        } else {
            $this->addFlash(
                'danger',
                $this->trans('app.calendar.features.create.error')
            );
        }

        return $this->redirectToRoute('app.calendar.feature.index');
    }

    #[Route('/{id}', name: 'app.calendar.feature.edit', methods: ['GET', 'POST'])]
    public function edit(FeatureEntity $feature, Request $request): Response
    {
        $form = $this->createForm(FeatureType::class, $feature);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $feature = $form->getData();
                $this->entityManager->persist($feature);
                $this->entityManager->flush();

                $this->addFlash(
                    'success',
                    $this->trans('app.calendar.features.edit.success', ['%name%' => $feature->getName()])
                );

                return $this->redirectToRoute('app.calendar.feature.index');
            } else {
                $this->addFlash(
                    'danger',
                    $this->trans('app.calendar.features.edit.error', ['%name%' => $feature->getName()])
                );
            }
        }

        return $this->render('page/feature/edit.html.twig', [
            'feature' => $feature,
            'editForm' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app.calendar.feature.delete', methods: ['POST'])]
    #[IsGranted(UserEntity::ROLE_ADMIN)]
    public function delete(FeatureEntity $feature): Response
    {
        $this->entityManager->remove($feature);
        $this->entityManager->flush();

        $this->addFlash(
            'success',
            $this->trans('app.calendar.features.delete.success', ['%name%' => $feature->getName()])
        );

        return $this->redirectToRoute('app.calendar.feature.index');
    }
}
