<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\EventTemplate\Controller;

use SilvioKennecke\ClubEventCalendar\Administration\User\UserEntity;
use SilvioKennecke\ClubEventCalendar\Framework\Controller\AppController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/event-template')]
class EventTemplateController extends AppController
{
    #[Route('', name: 'app.calendar.templates.index', methods: ['GET'])]
    #[IsGranted(UserEntity::ROLE_ADMIN)]
    public function list(): Response
    {
        return $this->render('page/event-template/list.html.twig');
    }
}
