<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:admin-register',
    description: 'Register the admin user',
)]
class UserRegisterCommand extends Command
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface      $entityManager;
    private ValidatorInterface          $validator;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager,string $name = null)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->validator = Validation::createValidator();

        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $question = $this->getHelper('question');

        $output->writeln(
            [
                '<fg=red>',
                '██████╗  █████╗ ██████╗ ██╗   ██╗██╗    ██╗██╗██╗     ██╗  ██╗   ██╗',
                '██╔══██╗██╔══██╗██╔══██╗╚██╗ ██╔╝██║    ██║██║██║     ██║  ╚██╗ ██╔╝',
                '██████╔╝███████║██████╔╝ ╚████╔╝ ██║ █╗ ██║██║██║     ██║   ╚████╔╝ ',
                '██╔═══╝ ██╔══██║██╔═══╝   ╚██╔╝  ██║███╗██║██║██║     ██║    ╚██╔╝  ',
                '██║     ██║  ██║██║        ██║   ╚███╔███╔╝██║███████╗███████╗██║   ',
                '╚═╝     ╚═╝  ╚═╝╚═╝        ╚═╝    ╚══╝╚══╝ ╚═╝╚══════╝╚══════╝╚═╝   ',
                '</>',
           ]
        );

        /**
         * Check if the admin user already exists
         */
        $registeredAdmin = $this->entityManager->getRepository(User::class)->findAll();

        if ($registeredAdmin) {
            $io->error('Le compte administrateur existe déjà');
            return Command::FAILURE;
        }


        /**
         * Check email validity
         */
        $questionEmail = new Question("Indiquez votre adresse email:\r\n");
        $inputEmail = $question->ask($input, $output, $questionEmail);

        $emailConstraints[] = $this->validator->validate($inputEmail, [
            new Email([
                'message' => 'L\'adresse email n\'est pas valide',
            ]),
        ]);

        $this->displayViolations($emailConstraints, $io);


        /**
         * Check password validity
         */
        $questionPassword = new Question("Indiquez votre mot de passe:\r\n");
        $questionPassword->setHidden(true);
        $questionPassword->setHiddenFallback(false);
        $inputPassword = $question->ask($input, $output, $questionPassword);

        $passwordConstraints[] = $this->validator->validate($inputPassword, [
            new Length([
                'min' => 8,
                'minMessage' => "Votre mot de passe doit contenir au moins 8 caractères."
            ]),
            new NotCompromisedPassword(['message' => "Mot de passe compromis, veuillez en choisir un autre."])
        ]);

        $this->displayViolations($passwordConstraints, $io);


        /**
         * Create the admin user if no violations detected
         */
        $this->createUser($inputEmail, $inputPassword);

        $io->success('Le compte administrateur a bien été créé');
        return Command::SUCCESS;
    }

    /**
     * @param $constraints
     * @param $io
     * Check if there are any violations and exit if there are
     */
    private function displayViolations($constraints, $io): void
    {
        $violationCount = 0;

        foreach ($constraints as $violations) {
            if (0 !== count($violations)) {
                foreach ($violations as $violation) {
                    $io->warning($violation->getMessage());
                    $violationCount++;
                }
            }
        }

        if ($violationCount > 0) {
            exit;
        }
    }

    /**
     * @param mixed $inputEmail
     * @param mixed $inputPassword
     * @return void
     * Create and persist the admin user
     */
    public function createUser(mixed $inputEmail, mixed $inputPassword): void
    {
        $user = new User();
        $user->setEmail($inputEmail);
        $user->setPassword($this->passwordHasher->hashPassword($user, $inputPassword));
        $user->setRoles(['ROLE_ADMIN']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
