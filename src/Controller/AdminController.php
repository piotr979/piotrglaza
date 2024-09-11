<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/base.html.twig');
    }
    #[Route('/articles', name:'admin_articles')]
    public function articles(): Response
    {
        return $this->render('admin/articles.html.twig');
    }
    #[Route('/categories', name:'admin_categories')]
    public function categories(): Response
    {
        return $this->render('admin/categories.html.twig');
    }
    #[Route('/tags', name: 'admin_tags')]
    public function tags(): Response
    {
        return $this->render('admin/tags.html.twig');
    }
    #[Route('/settings', name: 'admin_settings')]
    public function settings(): Response
    {
        return $this->render('admin/settings.html.twig');
    }
}
