<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatsRepository")
 */
class Stats
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $xp;

    /**
     * @ORM\Column(type="integer")
     */
    private $groundXp;

    /**
     * @ORM\Column(type="integer")
     */
    private $airXp;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="integer")
     */
    private $nationalRank;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="stats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profile;

    public function __construct()
    {
        $this->date = new \DateTime("NOW");
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getXp(): ?int
    {
        return $this->xp;
    }

    /**
     * @param int $xp
     * @return Stats
     */
    public function setXp(int $xp): self
    {
        $this->xp = $xp;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getGroundXp(): ?int
    {
        return $this->groundXp;
    }

    /**
     * @param int $groundXp
     * @return Stats
     */
    public function setGroundXp(int $groundXp): self
    {
        $this->groundXp = $groundXp;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAirXp(): ?int
    {
        return $this->airXp;
    }

    /**
     * @param int $airXp
     * @return Stats
     */
    public function setAirXp(int $airXp): self
    {
        $this->airXp = $airXp;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return Stats
     */
    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNationalRank(): ?int
    {
        return $this->nationalRank;
    }

    /**
     * @param int $nationalRank
     * @return Stats
     */
    public function setNationalRank(int $nationalRank): self
    {
        $this->nationalRank = $nationalRank;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return Stats
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Profile|null
     */
    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    /**
     * @param Profile|null $profile
     * @return Stats
     */
    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }
}
