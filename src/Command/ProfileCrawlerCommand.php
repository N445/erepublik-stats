<?php

namespace App\Command;

use App\Entity\Profile;
use App\Entity\Stats;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ProfileCrawlerCommand extends Command
{
    protected static $defaultName = 'app:profile:get-data';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Profile[]
     */
    private $profiles;

    /**
     * ProfileCrawlerCommand constructor.
     * @param null                   $name
     * @param ProfileRepository      $profileRepository
     * @param EntityManagerInterface $em
     */
    public function __construct($name = null, ProfileRepository $profileRepository, EntityManagerInterface $em)
    {
        $this->profiles = $profileRepository->getActiveProfiles();
        $this->em       = $em;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Récupére les data des profiles');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $i = 0;
        foreach ($this->profiles as $profile) {
            $url = sprintf(Profile::JSON_BASE_PATH, $profile->getIdentifiant());
            if (!$data = $this->getUrlContent($url)) {
                continue;
            }
            $i++;
            $stats = new Stats();
            $stats->setLevel($data->citizenAttributes->level)
                  ->setXp($data->citizenAttributes->experience_points)
                  ->setAirXp($data->military->militaryData->aircraft->points)
                  ->setGroundXp($data->military->militaryData->ground->points)
                  ->setNationalRank($data->nationalRank->xp)
                  ->setProfile($profile)
            ;
            $this->em->persist($stats);
        }
        $this->em->flush();
        $io->success(sprintf('les data de %S profiles ont été récupéré.', $i));
    }

    /**
     * @param $url
     * @return bool|mixed
     */
    private function getUrlContent($url)
    {
        try {
            return json_decode(file_get_contents($url));
        } catch (\Exception $exception) {
            return false;
        }
    }
}
