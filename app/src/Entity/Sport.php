<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SportRepository::class)]
class Sport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_sport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSport(): ?string
    {
        return $this->nom_sport;
    }

    public function setNomSport(string $nom_sport): static
    {
        $this->nom_sport = $nom_sport;

        return $this;
    }
}
