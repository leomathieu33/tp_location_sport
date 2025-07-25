<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil.html.twig');
    }

    #[Route('/accueil', name: 'accueil_alternative')]
    public function accueilAlt(): Response
    {
        return $this->render('accueil.html.twig');
    }
}