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

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $date_reservation_debut = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $date_reservation_fin = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Terrain::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Terrain $terrain = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservationDebut(): ?\DateTimeInterface
    {
        return $this->date_reservation_debut;
    }

    public function setDateReservationDebut(\DateTimeInterface $date_reservation_debut): self
    {
        $this->date_reservation_debut = $date_reservation_debut;
        return $this;
    }

    public function getDateReservationFin(): ?\DateTimeInterface
    {
        return $this->date_reservation_fin;
    }

    public function setDateReservationFin(\DateTimeInterface $date_reservation_fin): self
    {
        $this->date_reservation_fin = $date_reservation_fin;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getTerrain(): ?Terrain
    {
        return $this->terrain;
    }

    public function setTerrain(?Terrain $terrain): self
    {
        $this->terrain = $terrain;
        return $this;
    }
}