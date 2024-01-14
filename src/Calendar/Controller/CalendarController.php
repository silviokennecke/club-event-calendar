<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Calendar\Controller;

use SilvioKennecke\ClubEventCalendar\Framework\Controller\AppController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/calendar')]
class CalendarController extends AppController
{
    #[Route('', name: 'app.calendar', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render('page/calendar/index.html.twig');
    }
}
