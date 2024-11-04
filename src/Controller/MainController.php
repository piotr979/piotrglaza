<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Contact;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/article/{id}', name: 'article')]
    public function showArticle(int $id, EntityManagerInterface $em): Response {
        $article = $em->getRepository(Article::class)->find($id);
        dump($article);exit;
        return $this->render('main/article.html.twig', [
            'article' => $article,
        ]);
    }
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request): Response 
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            dump('submit');
            $contact = $form->getData();
            $this->addFlash('notice', 'Your message has been submitted.');
            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
