<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $error = null;

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user || !$hasher->isPasswordValid($user, $password)) {
                $error = "Email ou mot de passe incorrect.";
            } else {
                // Ici tu peux gérer la connexion (session, token, etc.)
                // Pour l’instant, juste une redirection vers l’accueil
                return $this->redirectToRoute('app_accueil');
            }
        }

        return $this->render('login.html.twig', ['error' => $error]);
    }
}