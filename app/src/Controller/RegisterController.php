<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request;
            if ($data->get('password') !== $data->get('confirm_password')) {
                return $this->render('register.html.twig', ['error' => 'Les mots de passe ne correspondent pas.']);
            }

            if ($em->getRepository(User::class)->findOneBy(['email' => $data->get('email')])) {
                return $this->render('register.html.twig', ['error' => 'Email déjà utilisé.']);
            }

            $user = new User();
            $user->setNom($data->get('nom'));
            $user->setEmail($data->get('email'));
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($hasher->hashPassword($user, $data->get('password')));
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('register.html.twig');
    }
}