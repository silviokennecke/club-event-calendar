<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Administration\User\Controller;

use SilvioKennecke\ClubEventCalendar\Framework\Controller\AppController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AppController
{
    #[Route('/login', name: 'app.login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app.home', [], Response::HTTP_TEMPORARY_REDIRECT);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('page/login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app.logout')]
    public function logout(): Response
    {
        $this->addFlash(
            'success',
            $this->trans('user.logoutSuccess')
        );
        return $this->redirectToRoute('app.login');
    }
}
