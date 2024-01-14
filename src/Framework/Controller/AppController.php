<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Contracts\Translation\TranslatorInterface;

class AppController extends AbstractController
{
    protected TranslatorInterface $translator;

    #[Required]
    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;
    }

    protected function trans(string $id, array $parameters = []): string
    {
        return $this->translator->trans($id, $parameters);
    }
}
