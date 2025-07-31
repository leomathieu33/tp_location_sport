<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SportRepository::class)]
class Sport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, name: "nom_sport")]
    private ?string $nomSport = null;

    /**
     * @var Collection<int, Terrain>
     */
    #[ORM\OneToMany(mappedBy: 'sport', targetEntity: Terrain::class)]
    private Collection $terrains;

    public function __construct()
    {
        $this->terrains = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSport(): ?string
    {
        return $this->nomSport;
    }

    public function setNomSport(string $nomSport): static
    {
        $this->nomSport = $nomSport;
        return $this;
    }

    /**
     * @return Collection<int, Terrain>
     */
    public function getTerrains(): Collection
    {
        return $this->terrains;
    }

    public function addTerrain(Terrain $terrain): static
    {
        if (!$this->terrains->contains($terrain)) {
            $this->terrains[] = $terrain;
            $terrain->setSport($this);
        }

        return $this;
    }

    public function removeTerrain(Terrain $terrain): static
    {
        if ($this->terrains->removeElement($terrain)) {
            if ($terrain->getSport() === $this) {
                $terrain->setSport(null);
            }
        }

        return $this;
    }
}