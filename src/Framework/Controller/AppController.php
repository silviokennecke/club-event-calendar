<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

class AppController extends AbstractController
{
    protected function getTranslator(): TranslatorInterface
    {
        return $this->container->get('translator');
    }
}
