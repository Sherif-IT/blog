<?php

namespace App\Controller\Show;

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

class ShowArticleController extends AbstractController
{

     /**
     * @Route("/blog/{id}", name="show_article")
     */
    public function show($id, Request $request)
    { 
        $article = $this->getDoctrine()
            ->getRepository(Article::class)->find($id);
        //TODO charger commentaires avc id dns table commentaires
        $newComment = new Commentaire();
        $idArt = $article->getId();
        $comments = $this->getDoctrine()
            ->getRepository(Commentaire::class)->findAll($idArt);
        $form = $this->createForm(CommentFormType::class, $newComment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $newComment->setIdArticle($article);
            $this->entityManager->persist($newComment);
            $this->entityManager->flush();

            return $this->redirectToRoute('show_article', ['id' => $idArt ]);
        }

        return $this->render('show_article/index.html.twig', [
            'controller_name' => 'BlogController',
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }
}
