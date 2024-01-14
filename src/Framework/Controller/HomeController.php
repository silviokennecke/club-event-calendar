<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Framework\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AppController
{
    #[Route('/', name: 'app.home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->redirectToRoute('app.calendar');
    }
}
