<?php

namespace App\Controller;

use App\Repository\ProfileRepository;
use App\Repository\StatsRepository;
use App\Service\StatsFormater;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @var StatsFormater
     */
    private $statsFormater;

    /**
     * @var StatsRepository
     */
    private $statsRepository;

    /**
     * @var ProfileRepository
     */
    private $profileRepository;

    /**
     * DefaultController constructor.
     * @param StatsRepository   $statsRepository
     * @param StatsFormater     $statsFormater
     * @param ProfileRepository $profileRepository
     */
    public function __construct(StatsRepository $statsRepository, StatsFormater $statsFormater, ProfileRepository $profileRepository)
    {
        $this->statsFormater     = $statsFormater;
        $this->statsRepository   = $statsRepository;
        $this->profileRepository = $profileRepository;
    }

    /**
     * @Route("/", name="HOMEPAGE")
     */
    public function index()
    {
//        dump($this->statsRepository->getStats());
        dump($this->statsFormater->getFormatedProfiles($this->profileRepository->getProfilesStats()));
        return $this->render('default/index.html.twig', [
//            'stats' => $this->statsFormater->getFormatedStats($this->statsRepository->getStats()),
'stats' => $this->statsFormater->getFormatedProfiles($this->profileRepository->getProfilesStats()),
        ]);
    }
}
