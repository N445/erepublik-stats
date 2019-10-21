<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $identifiant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stats", mappedBy="profile")
     */
    private $stats;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * Profile constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->identifiant = $id;
        $this->active      = true;
        $this->stats       = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    /**
     * @param string $identifiant
     * @return Profile
     */
    public function setIdentifiant(string $identifiant): self
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    /**
     * @return Collection|Stats[]
     */
    public function getStats(): Collection
    {
        return $this->stats;
    }

    /**
     * @param Stats $stat
     * @return Profile
     */
    public function addStat(Stats $stat): self
    {
        if (!$this->stats->contains($stat)) {
            $this->stats[] = $stat;
            $stat->setProfile($this);
        }

        return $this;
    }

    /**
     * @param Stats $stat
     * @return Profile
     */
    public function removeStat(Stats $stat): self
    {
        if ($this->stats->contains($stat)) {
            $this->stats->removeElement($stat);
            // set the owning side to null (unless already changed)
            if ($stat->getProfile() === $this) {
                $stat->setProfile(null);
            }
        }

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
