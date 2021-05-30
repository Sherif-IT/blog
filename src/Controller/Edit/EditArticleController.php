<?php

namespace App\Controller\Edit;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\Commentaire;
use App\Form\ArticleFormType;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EditArticleController extends AbstractController
{

    #[Route('/edit', name: 'blog_edit')]
    public function index(Request $request): Response
    {   
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(1);
        $article = new Article();
        $article->setIdUser($user); 
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($article);
            $this->entityManager->flush($article);
        }
        return $this->render('edit_article/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
