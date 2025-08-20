<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/terrains')]
class AdminTerrainController extends AbstractController
{
    // ✅ Liste des terrains (admin seulement)
    #[Route('/', name: 'admin_terrains_index', methods: ['GET'])]
    public function index(TerrainRepository $terrainRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/terrains/index.html.twig', [
            'terrains' => $terrainRepository->findAll(),
        ]);
    }

    // ✅ Ajout d’un terrain (admin seulement)
    #[Route('/new', name: 'admin_terrains_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($terrain);
            $em->flush();

            $this->addFlash('success', 'Terrain ajouté avec succès.');
            return $this->redirectToRoute('admin_terrains_index');
        }

        return $this->render('admin/terrains/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // ✅ Modification d’un terrain (admin seulement)
    #[Route('/{id}/edit', name: 'admin_terrains_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Terrain $terrain, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Terrain modifié avec succès.');
            return $this->redirectToRoute('admin_terrains_index');
        }

        return $this->render('admin/terrains/edit.html.twig', [
            'form' => $form->createView(),
            'terrain' => $terrain,
        ]);
    }

    // ✅ Suppression d’un terrain (admin seulement)
    #[Route('/{id}/delete', name: 'admin_terrains_delete', methods: ['POST'])]
    public function delete(Request $request, Terrain $terrain, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$terrain->getId(), $request->request->get('_token'))) {
            $em->remove($terrain);
            $em->flush();

            $this->addFlash('success', 'Terrain supprimé avec succès.');
        }

        return $this->redirectToRoute('admin_terrains_index');
    }
}