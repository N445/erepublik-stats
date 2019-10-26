<?php

namespace App\Repository;

use App\Entity\Profile;
use DateInterval;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    /**
     * @return Profile[]
     */
    public function getActiveProfiles()
    {
        return $this->createQueryBuilder('p')
                    ->where('p.active = true')
                    ->getQuery()
                    ->getResult()
            ;
    }

    /**
     * @return Profile[]
     */
    public function getProfilesStats()
    {
        return $this->createQueryBuilder('p')
                    ->addSelect('stats')
                    ->where('p.active = true')
                    ->leftJoin('p.stats', 'stats')
                    ->orderBy('stats.date', 'ASC')
                    ->getQuery()
                    ->getResult()
            ;
    }

    /**
     * @return Profile[]
     * @throws \Exception
     */
    public function getProfilesStatsDateBetween()
    {
        $now    = new \DateTime("NOW");
        $before = clone $now;
        $before->sub(new DateInterval('P7D'));

        return $this->createQueryBuilder('p')
                    ->addSelect('stats')
                    ->where('p.active = true')
                    ->leftJoin('p.stats', 'stats')
                    ->orderBy('stats.date', 'ASC')
                    ->where('stats.date BETWEEN :before AND :now')
                    ->setParameter('before', $before)
                    ->setParameter('now', $now)
                    ->getQuery()
                    ->getResult()
            ;
    }

    // /**
    //  * @return Profile[] Returns an array of Profile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Profile
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
