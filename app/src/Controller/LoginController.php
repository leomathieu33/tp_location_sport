<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; // ou Attribute selon ta version Symfony
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, on le redirige vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('app_accueil');
        }

        // Récupération de la dernière erreur de connexion, s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupération du dernier nom d'utilisateur saisi
        $lastUsername = $authenticationUtils->getLastUsername();

        // Affichage du formulaire de connexion
        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Cette méthode peut rester vide.
        // Symfony interceptera automatiquement cette route pour gérer la déconnexion.
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}