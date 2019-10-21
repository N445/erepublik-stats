<?php

namespace App\Command;

use App\Entity\Profile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class ProfileCreateCommand extends Command
{
    protected static $defaultName = 'app:profile:create';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ProfileCreateCommand constructor.
     * @param null                   $name
     * @param EntityManagerInterface $em
     */
    public function __construct($name = null, EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Créer un profile')
            ->addArgument('id', InputArgument::OPTIONAL, 'Identifiant')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io       = new SymfonyStyle($input, $output);
        $id       = $input->getArgument('id');
        $helper   = $this->getHelper('question');
        $question = new Question('Entrez un identifiant : ');
        while (!$id) {
            $id = $helper->ask($input, $output, $question);
        }

        $this->em->persist(new Profile($id));
        $this->em->flush();

        $io->success(sprintf('Le profile avec l\'idetifiant %s à été crée', $id));
    }
}
