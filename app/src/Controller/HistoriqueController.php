<?php

namespace App\Controller;

use App\Document\RechercheHistorique;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HistoriqueController extends AbstractController
{
    #[Route('/historique', name: 'historique_recherches')]
    public function afficher(DocumentManager $dm): Response
    {
        $recherches = $dm->getRepository(RechercheHistorique::class)
                         ->findBy([], ['createdAt' => 'DESC']);

        return $this->render('historique/index.html.twig', [
            'recherches' => $recherches,
        ]);
    }

    #[Route('/historique/supprimer', name: 'historique_supprimer', methods: ['POST'])]
    public function supprimerTout(Request $request, DocumentManager $dm): RedirectResponse
    {
        if (!$this->isCsrfTokenValid('delete_all', $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide.');
        }

        $recherches = $dm->getRepository(RechercheHistorique::class)->findAll();
        foreach ($recherches as $recherche) {
            $dm->remove($recherche);
        }
        $dm->flush();

        $this->addFlash('success', 'Historique supprimé avec succès.');
        return $this->redirectToRoute('historique_recherches');
    }
}