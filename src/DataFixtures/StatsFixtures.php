<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\Stats;
use App\Repository\ProfileRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class StatsFixtures extends Fixture
{
    /**
     * @var array
     */
    private $profiles;

    private $faker;

    /**
     * StatsFixtures constructor.
     * @param ProfileRepository $profileRepository
     */
    public function __construct()
    {
        $this->profiles = [
            '9541670' => 'NaAaS',
            '9541668' => 'Claaaa',
            '9543015' => 'Rudak2.1',
        ];
        $this->faker    = Factory::create('fr');
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->profiles as $identifiant => $name) {
            $profile = (new Profile($identifiant))->setName($name);
            $this->addStatsToProfile($profile, $manager);
            $manager->persist($profile);
        }
        $manager->flush();
    }

    private function addStatsToProfile(Profile &$profile, ObjectManager $manager)
    {
        for ($i = 1; $i <= 50; $i++) {
            $stats = new Stats();
            $stats->setProfile($profile)
                  ->setDate($this->faker->dateTimeBetween('-30 days', 'now'))
                  ->setNationalRank($i * rand(5, 100))
                  ->setGroundXp($i * rand(500, 20000))
                  ->setAirXp($i * rand(500, 10000))
                  ->setXp($i * rand(200, 6000))
                  ->setLevel($i * rand(5, 60))
            ;
            $manager->persist($stats);
        }
    }
}
