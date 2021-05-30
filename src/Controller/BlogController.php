<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\Commentaire;
use App\Form\ArticleType;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $userRepository;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $userRepository = $entityManager->getRepository('App:User');
        $articlesRepository = $entityManager->getRepository('App:Article');
        $commentsRepository = $entityManager->getRepository('App:Commentaire');
    }

    #[Route('/edit', name: 'blog_edit')]
    public function index(Request $request): Response
    {   
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(1);
        $article = new Article();
        $article->setIdUser($user); 
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($article);
            $this->entityManager->flush($article);
        }
        return $this->render('blog/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

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

        return $this->render('blog/show.html.twig', [
            'controller_name' => 'BlogController',
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }
}
