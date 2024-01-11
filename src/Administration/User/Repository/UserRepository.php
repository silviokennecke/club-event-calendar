<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Administration\User\Repository;

use Doctrine\ORM\EntityRepository;
use SilvioKennecke\ClubEventCalendar\Administration\User\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class UserRepository extends EntityRepository implements PasswordUpgraderInterface
{
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            return;
        }

        $user->setPassword($newHashedPassword);
    }
}