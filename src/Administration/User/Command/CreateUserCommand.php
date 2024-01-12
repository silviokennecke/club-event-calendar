<?php

declare(strict_types=1);

namespace SilvioKennecke\ClubEventCalendar\Administration\User\Command;

use Doctrine\ORM\EntityManagerInterface;
use SilvioKennecke\ClubEventCalendar\Administration\User\UserEntity;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Create a new user',
)]
class CreateUserCommand extends Command
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the user.')
            ->addArgument('email', InputArgument::OPTIONAL, 'The email of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        if ($input->getArgument('name') === null) {
            $question = new Question('Name: ');
            $input->setArgument('name', $helper->ask($input, $output, $question));
        }

        if ($input->getArgument('email') === null) {
            $question = new Question('E-Mail: ');
            $input->setArgument('email', $helper->ask($input, $output, $question));
        }

        $question = new Question('Password: ');
        $question->setHidden(true);
        $password = $helper->ask($input, $output, $question);

        // create user
        $user = new UserEntity();
        $user->setName($input->getArgument('name'));
        $user->setEmail($input->getArgument('email'));
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }

}