<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_accueil');
        }

        if ($request->isMethod('POST')) {
            $nom = $request->request->get('nom');
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $confirmPassword = $request->request->get('confirm_password');

            if ($password !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas.";
                return $this->render('/register.html.twig', ['error' => $error]);
            }

            // Vérifier si email existe déjà
            $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $email]);
            if ($existingUser) {
                $error = "Cet email est déjà utilisé.";
                return $this->render('/register.html.twig', ['error' => $error]);
            }

            $user = new User();
            $user->setNom($nom);
            $user->setEmail($email);

            $hashedPassword = $hasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('/register.html.twig');
    }
}