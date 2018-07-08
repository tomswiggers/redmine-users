<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class CreateUserCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:create-user')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addOption('apiKey', 'a', InputOption::VALUE_REQUIRED)
            ->addOption('baseUrl', 'b', InputOption::VALUE_REQUIRED)
            ->addOption('firstname', 'f', InputOption::VALUE_REQUIRED)
            ->addOption('lastname', 'l', InputOption::VALUE_REQUIRED)
            ->addOption('mail', 'm', InputOption::VALUE_REQUIRED)
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Create new redmine users.');

        // User data
        $firstname = $input->getOption('firstname');
        $lastname = $input->getOption('lastname');
        $mail = $input->getOption('mail');
        $password = $input->getOption('password');
        $login = $mail;

        // redmine config
        $baseUrl = $input->getOption('baseUrl');
        $url = $baseUrl .'/users.json';
        $apiKey = $input->getOption('apiKey');

        // Create user object
        $user = [
            'user' => [
                'login' => $login,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'mail' => $mail,
                'password' => $password,
                'must_change_passwd' => TRUE,
            ]
        ];

        $headers = [
            'X-Redmine-API-Key: '. $apiKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($user));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_VERBOSE, '1');

        $response = curl_exec ($ch);

        curl_close ($ch);

        var_dump($response);
    }
}
