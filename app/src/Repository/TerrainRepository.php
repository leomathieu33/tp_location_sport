<?php

namespace App\Repository;

use App\Entity\Terrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TerrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terrain::class);
    }

    /**
     * Recherche des terrains disponibles selon la ville, le sport et la date.
     *
     * @param string $ville
     * @param string $sport
     * @param \DateTimeInterface $date
     * @return Terrain[]
     */
public function searchTerrains(string $ville, string $sport, \DateTimeInterface $date): array
{
    return $this->createQueryBuilder('t')
    ->join('t.sport', 's')
    ->leftJoin('t.reservations', 'r', 'WITH', 'r.date_reservation_debut <= :date AND r.date_reservation_fin >= :date')
    ->andWhere('t.ville = :ville')
    ->andWhere('s.nomSport = :sport')
    ->andWhere('r.id IS NULL')
    ->setParameter('ville', $ville)
    ->setParameter('sport', $sport)
    ->setParameter('date', $date)
    ->getQuery()
    ->getResult(); 
}
}