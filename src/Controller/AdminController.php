<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use App\Form\ArticleType;
use App\Form\CategoryType;
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
    public function articles(PaginatorInterface $paginator, Request $request): Response
    {
        $dql = "SELECT a from App\Entity\Article a";
        $query = $this->entityManager->createQuery($dql);
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            10
        );
        return $this->render('admin/articles/articles.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    #[Route('/article-edit/{id}', name: 'admin_article_edit')]
    public function editArticle(EntityManagerInterface $em, Request $request, int $id = 0): Response
    {
        $article = new Article();
        $isNewArticle = true;
        if ($id != 0 ) {
            $article = $em->getRepository(Article::class)->find($id);
            if (!$article) {
                throw $this->createNotFoundException('No article found for id' . $id);
            }
            $isNewArticle = false;
        }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('admin_articles');
        }
        return $this->render('admin/articles/article-edit.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'isNewCategory' => $isNewArticle,
        ]);
    }
    #[Route('/article-delete/{id}', name: "admin_article_delete")]
    public function deleteArticle(EntityManagerInterface $em, Request $request, int $id): Response
    {
        $article = $em->getRepository(Article::class)->find($id);
        if (!$article) {
            throw $this->createNotFoundException("Tag not found");
        }
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute("admin_articles");
    }
    #[Route('/categories', name:'admin_categories')]
    public function categories(PaginatorInterface $paginator, Request $request): Response
    {
        $dql = "SELECT c from App\Entity\Category c";
        $query = $this->entityManager->createQuery($dql);
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            10
        );
        return $this->render('admin/categories/categories.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    #[Route('/category-edit/{id}', name: 'admin_category_edit')]
    public function newCategory(EntityManagerInterface $em, Request $request, int $id = 0): Response
    {
        $category = new Category();
        $isNewCategory = true;
        if ($id != 0 ) {
            $category = $em->getRepository(Category::class)->find($id);
            if (!$category) {
                throw $this->createNotFoundException('No category found for id' . $id);
            }
            $isNewCategory = false;
        }
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('admin_categories');
        }
        return $this->render('admin/categories/category-edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
            'isNewCategory' => $isNewCategory,
        ]);
    }
    #[Route('/category-delete/{id}', name: "admin_category_delete")]
    public function deleteCategory(EntityManagerInterface $em, Request $request, int $id): Response
    {
        $category = $em->getRepository(Category::class)->find($id);
        if (!$category) {
            throw $this->createNotFoundException("Category not found");
        }
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute("admin_categories");
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
        return $this->render('admin/tags/tags.html.twig', [
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
        return $this->render('admin/tags/tag-edit.html.twig', [
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
        return $this->render('admin/settings/settings.html.twig');
    }
}
