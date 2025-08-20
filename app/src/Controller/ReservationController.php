<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Terrain;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
   #[Route('/reservation/{terrainId<\d+>}', name: 'app_reservation', methods: ['GET', 'POST'])]
public function reserver(int $terrainId, Request $request, EntityManagerInterface $em): Response
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    $terrain = $em->getRepository(Terrain::class)->find($terrainId);
    if (!$terrain) {
        throw $this->createNotFoundException('Terrain non trouvé');
    }

    if ($request->isMethod('POST')) {
        $dateDebut = new \DateTime($request->request->get('date_debut'));
        $dateFin = new \DateTime($request->request->get('date_fin'));

        $reservation = new Reservation();
        $reservation->setUser($this->getUser());
        $reservation->setTerrain($terrain);
        $reservation->setDateReservationDebut($dateDebut);
        $reservation->setDateReservationFin($dateFin);

        $em->persist($reservation);
        $em->flush();

        return $this->redirectToRoute('app_accueil');
    }

    // Récupération des réservations de l'utilisateur connecté
    $reservations = $em->getRepository(Reservation::class)->findBy([
        'user' => $this->getUser()
    ]);

    // Passage de terrain ET reservations au template
    return $this->render('reservation/reserver.html.twig', [
        'terrain' => $terrain,
        'reservations' => $reservations,
    ]);
}

    #[Route('/mes-reservations', name: 'app_reservation_index', methods: ['GET'])]
public function index(EntityManagerInterface $em): Response
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    $reservations = $em->getRepository(Reservation::class)->findBy([
        'user' => $this->getUser()
    ]);

    return $this->render('reservation/index.html.twig', [
        'reservations' => $reservations,
    ]);
}

   

    #[Route('/reservation/{id}/cancel', name: 'app_reservation_cancel', methods: ['POST'])]
public function cancel(int $id, EntityManagerInterface $em): Response
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    $reservation = $em->getRepository(Reservation::class)->find($id);
    if (!$reservation) {
        throw $this->createNotFoundException('Réservation non trouvée');
    }

    // Vérifier que c’est bien l’utilisateur qui a réservé
    if ($reservation->getUser() !== $this->getUser()) {
        throw $this->createAccessDeniedException('Vous ne pouvez pas annuler cette réservation');
    }

    $em->remove($reservation);
    $em->flush();

    return $this->redirectToRoute('app_reservation_index');
}
}