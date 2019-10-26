<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 21/10/2019
 * Time: 19:53
 */

namespace App\Service;

use App\Entity\Profile;
use App\Entity\Stats;

class StatsFormater
{
    /**
     * @param Stats[] $stats
     * @return array
     */
    public function getFormatedStats(array $stats)
    {
        return json_encode(array_map(function (Stats $item) {
            return [
                'name' => $item->getProfile()->getName(),
                'date' => $item->getDate(),
                'data' => [
                    'xp'           => $item->getXp(),
                    'airxp'        => $item->getAirXp(),
                    'groundxp'     => $item->getGroundXp(),
                    'level'        => $item->getLevel(),
                    'nationalrank' => $item->getNationalRank(),
                ],
            ];
        }, $stats));
    }

    /**
     * @param Profile[] $profiles
     * @return array
     */
    public function getFormatedProfiles(array $profiles)
    {
        return json_encode(array_map(function (Profile $profile) {
            return [
                'name'        => $profile->getName(),
                'data'        => array_map(function (Stats $stats) {
                    return [
                        'x' => $stats->getDate()->format('Y-n-j'),
                        'y' => $stats->getXp(),
                    ];
                }, $profile->getStats()->toArray()),
                'lineTension' => '0',
            ];
        }, $profiles));
    }
}