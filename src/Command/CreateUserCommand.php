<?php

namespace SimpleUser\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use SimpleUser\Service\UserManager;


class CreateUserCommand extends Command
{
    /**
     * @var UserManager
     */
    protected $userManager;

    public function __construct(?string $name = null, UserManager $userManager)
    {
        parent::__construct($name);
        $this->userManager = $userManager;
    }

    protected function configure()
    {
        $this
            ->setName('simple-user:create-user')
            ->addArgument('email', InputArgument::REQUIRED, 'The username of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.')
            ->addArgument(
                'roles',
                InputArgument::OPTIONAL,
                'The roles of the user. Split by comma: ROLE_USER, ROLE_SONATA_ADMIN')
            ->setDescription('Create a new user.')
            ->setHelp('This command allows you to create a user')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $roles = explode(',', $input->getArgument('roles'));
        $email = $input->getArgument('email');
        $password  = $input->getArgument('password');

        $this->getUserManager()->createUser($email, $password, $roles);

        $output->writeln('User successfully generated!');
    }

    /**
     * @return UserManager
     */
    public function getUserManager(): UserManager
    {
        return $this->userManager;
    }
}