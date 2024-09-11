<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'user_registration')]
    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hasedPassword = $userPasswordHasher->hashPassword($user, $form->get('password')->getData());
            $user->setPassword($hasedPassword);
            $user->setRoles(['ROLE_ADMIN']);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','New user has been registered.');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/register.html.twig', [
            'controller_name' => 'RegistrationController',
            'form' => $form->createView(),
        ]);
    }
}
