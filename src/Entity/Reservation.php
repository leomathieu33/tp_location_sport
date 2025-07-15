<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'terrain')]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?terrain $terrain = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?sport $sport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTerrain(): ?terrain
    {
        return $this->terrain;
    }

    public function setTerrain(?terrain $terrain): static
    {
        $this->terrain = $terrain;

        return $this;
    }

    public function getSport(): ?sport
    {
        return $this->sport;
    }

    public function setSport(?sport $sport): static
    {
        $this->sport = $sport;

        return $this;
    }
}
