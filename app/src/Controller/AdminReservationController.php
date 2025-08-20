<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/reservations')]
class AdminReservationController extends AbstractController
{
    // ✅ Liste des réservations
    #[Route('/', name: 'admin_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    // ✅ Affichage d'une réservation
    #[Route('/{id}', name: 'admin_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    // ✅ Modification d'une réservation
    #[Route('/{id}/edit', name: 'admin_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Réservation mise à jour.');
            return $this->redirectToRoute('admin_reservation_index');
        }

        return $this->render('admin/reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    // ✅ Suppression d'une réservation
    #[Route('/{id}/delete', name: 'admin_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $em->remove($reservation);
            $em->flush();

            $this->addFlash('success', 'Réservation supprimée.');
        }

        return $this->redirectToRoute('admin_reservation_index');
    }
}