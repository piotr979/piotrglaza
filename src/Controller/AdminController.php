<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin')]
class AdminController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager) 
    {
    }
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
    public function tags(PaginatorInterface $paginator, Request $request): Response
    {
        $dql = "SELECT t from App\Entity\Tag t";
        $query = $this->entityManager->createQuery($dql);
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            10
        );
        return $this->render('admin/tags.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    #[Route('/tag-edit/{id}', name: 'admin_tag_edit')]
    public function newTag(EntityManagerInterface $em, Request $request, int $id = 0): Response
    {
        $tag = new Tag();
        $isNewTag = true;
        if ($id != 0 ) {
            $tag = $em->getRepository(Tag::class)->find($id);
            if (!$tag) {
                throw $this->createNotFoundException('No tag found for id' . $id);
            }
            $isNewTag = false;
        }
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();
            $em->persist($tag);
            $em->flush();
            return $this->redirectToRoute('admin_tags');
        }
        return $this->render('admin/tag-edit.html.twig', [
            'form' => $form->createView(),
            'tag' => $tag,
            'isNewTag' => $isNewTag,
        ]);
    }
    #[Route('/tag-delete/{id}', name: "admin_tag_delete")]
    public function deleteTag(EntityManagerInterface $em, Request $request, int $id): Response
    {
        $tag = $em->getRepository(Tag::class)->find($id);
        if (!$tag) {
            throw $this->createNotFoundException("Tag not found");
        }
        $em->remove($tag);
        $em->flush();
        return $this->redirectToRoute("admin_tags");
    }
    #[Route('/settings', name: 'admin_settings')]
    public function settings(): Response
    {
        return $this->render('admin/settings.html.twig');
    }
}
