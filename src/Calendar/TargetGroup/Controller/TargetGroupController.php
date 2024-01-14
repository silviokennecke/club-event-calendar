<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\TargetGroup\Controller;

use Doctrine\ORM\EntityManagerInterface;
use SilvioKennecke\ClubEventCalendar\Administration\User\UserEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\TargetGroup\TargetGroupEntity;
use SilvioKennecke\ClubEventCalendar\Calendar\TargetGroup\Type\TargetGroupType;
use SilvioKennecke\ClubEventCalendar\Framework\Controller\AppController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/calendar/target-group')]
#[IsGranted(UserEntity::ROLE_USER)]
class TargetGroupController extends AppController
{
    private EntityManagerInterface $entityManager;

    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app.calendar.target-group.index', methods: ['GET'])]
    public function list(): Response
    {
        $targetGroups = $this->entityManager->getRepository(TargetGroupEntity::class)
            ->createQueryBuilder('targetGroup')
            ->orderBy('targetGroup.name')
            ->getQuery()
            ->getArrayResult();

        $form = $this->createForm(TargetGroupType::class, new TargetGroupEntity(), [
            'method' => 'POST',
            'action' => $this->generateUrl('app.calendar.target-group.create'),
        ]);

        return $this->render('page/target-group/index.html.twig', [
            'targetGroups' => $targetGroups,
            'createForm' => $form,
        ]);
    }

    #[Route('/', name: 'app.calendar.target-group.create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $form = $this->createForm(TargetGroupType::class, new TargetGroupEntity());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $targetGroup = $form->getData();
            $this->entityManager->persist($targetGroup);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                $this->trans('app.calendar.targetGroups.create.success', ['%name%' => $targetGroup->getName()])
            );
        } else {
            $this->addFlash(
                'danger',
                $this->trans('app.calendar.targetGroups.create.error')
            );
        }

        return $this->redirectToRoute('app.calendar.target-group.index');
    }

    #[Route('/{id}', name: 'app.calendar.target-group.edit', methods: ['GET', 'POST'])]
    public function edit(TargetGroupEntity $targetGroup, Request $request): Response
    {
        $form = $this->createForm(TargetGroupType::class, $targetGroup);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $targetGroup = $form->getData();
                $this->entityManager->persist($targetGroup);
                $this->entityManager->flush();

                $this->addFlash(
                    'success',
                    $this->trans('app.calendar.targetGroups.edit.success', ['%name%' => $targetGroup->getName()])
                );

                return $this->redirectToRoute('app.calendar.target-group.index');
            } else {
                $this->addFlash(
                    'danger',
                    $this->trans('app.calendar.targetGroups.edit.error', ['%name%' => $targetGroup->getName()])
                );
            }
        }

        return $this->render('page/target-group/edit.html.twig', [
            'targetGroup' => $targetGroup,
            'editForm' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app.calendar.target-group.delete', methods: ['POST'])]
    #[IsGranted(UserEntity::ROLE_ADMIN)]
    public function delete(TargetGroupEntity $targetGroup): Response
    {
        $this->entityManager->remove($targetGroup);
        $this->entityManager->flush();

        $this->addFlash(
            'success',
            $this->trans('app.calendar.targetGroups.delete.success', ['%name%' => $targetGroup->getName()])
        );

        return $this->redirectToRoute('app.calendar.target-group.index');
    }
}
