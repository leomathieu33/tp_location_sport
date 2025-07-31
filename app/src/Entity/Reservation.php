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

    #[ORM\Column]
    private ?\DateTime $date_reservation_debut = null;

    #[ORM\Column]
    private ?\DateTime $date_reservation_fin = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Terrain $terrain = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservationDebut(): ?\DateTime
    {
        return $this->date_reservation_debut;
    }

    public function setDateReservationDebut(\DateTime $date_reservation_debut): static
    {
        $this->date_reservation_debut = $date_reservation_debut;

        return $this;
    }

    public function getDateReservationFin(): ?\DateTime
    {
        return $this->date_reservation_fin;
    }

    public function setDateReservationFin(\DateTime $date_reservation_fin): static
    {
        $this->date_reservation_fin = $date_reservation_fin;

        return $this;
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
}
