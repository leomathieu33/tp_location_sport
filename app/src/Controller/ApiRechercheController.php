<?php

namespace App\Controller;

use App\Repository\TerrainRepository; 
use Doctrine\ODM\MongoDB\DocumentManager;      
use App\Document\RechercheHistorique;         
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiRechercheController extends AbstractController
{
    #[Route('/api/recherche', name: 'api_recherche', methods: ['POST'])]
    public function recherche(Request $request, TerrainRepository $terrainRepo, DocumentManager $dm): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if ($data === null) {
                return $this->json(['error' => 'JSON invalide.'], 400);
            }

            $sport = $data['sport'] ?? null;
            $ville = $data['ville'] ?? null;
            $date = $data['date'] ?? null;

            if (!$sport || !$ville || !$date) {
                return $this->json(['error' => 'Champs manquants.'], 400);
            }

            $dateObj = \DateTime::createFromFormat('Y-m-d', $date);
            if (!$dateObj || $dateObj->format('Y-m-d') !== $date) {
                return $this->json(['error' => 'Format de date invalide. Utilisez YYYY-MM-DD.'], 400);
            }

            $terrains = $terrainRepo->searchTerrains($ville, $sport, $dateObj);

            if (!is_array($terrains)) {
                $terrains = [];
            }

            // === Enregistrement dans MongoDB ===
            $recherche = new RechercheHistorique($sport, $ville, $dateObj);
            $dm->persist($recherche);
            $dm->flush();

            $result = [];
            foreach ($terrains as $terrain) {
                $result[] = [
                    'nom' => $terrain->getReferenceTerrain(),
                    'ville' => $terrain->getVille(),
                    'sport' => $terrain->getSport()->getNomSport(),
                    'adresse' => $terrain->getAdresse(),
                    'disponible_le' => $dateObj->format('Y-m-d'),
                ];
            }

            return $this->json($result);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Erreur serveur : ' . $e->getMessage()], 500);
        }
    }
}