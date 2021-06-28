<?php

namespace App\Controller;

use App\Service\ImageUploader;
use App\Entity\Article;
use App\Entity\User;
use App\Entity\Commentaire;
use App\Form\ArticleFormType;
use App\Form\CategorieFormType;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
         

class ArticleController extends AbstractController
{
     /** @var EntityManagerInterface */
     private $entityManager;

     /** @var \Doctrine\Common\Persistence\ObjectRepository */
     private $userRepository;
 
     public function __construct(EntityManagerInterface $entityManager)
     {
         $this->entityManager = $entityManager; 
     }
     
      /**
     * @Route("/", name="index")
     */
    public function index( Request $request)
    { 
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)->findAll(); 
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)->findAll(); ; 
        return $this->render('index.html.twig', [  
            'articles' => $articles,  
            'categories' => $categories,
            /*'relatedArticles' => $relatedArticles,
            'user' => $user*/
        ]);
    }
      /**
     * @Route("/blog/{id}", name="show_article")
     */
    public function show($id, Request $request)
    { 
        $user = $this->getUser();
        $categoryRepo = $this->entityManager->getRepository('App:Categorie'); 
        $article = $this->getDoctrine()
            ->getRepository(Article::class)->find($id); 
        $tags = $article->getTags(); 
        $CaregoriesOfArticle = $article->getCategories();
        $categories = $categoryRepo->findAll();
        $relatedArticles = [];
        foreach ($CaregoriesOfArticle as $cat) { 
            $relatedArticles =  $cat->getArticles(); 
        }             
        $newComment = new Commentaire();  
        $comments = $this->getDoctrine()
            ->getRepository(Commentaire::class)->findByIdArticle($id); 
     
        $form = $this->createForm(CommentFormType::class, $newComment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $newComment->setIdArticle($article);
            $this->entityManager->persist($newComment);
            $this->entityManager->flush();

            return $this->redirectToRoute('show_article', ['id' => $id ]);
        }

        return $this->render('show_article/index.html.twig', [  
            'article' => $article,
            'tags' => $tags,
            'comments' => $comments,
            'form' => $form->createView(),
            'relatedArticles' => $relatedArticles,
            'categories' => $categories,
            'user' => $user
        ]);
    }

    /**
     * @Route("/edit/blog", name="blog_choose_cat")
     */ 
    public function editArticle(Request $request, ImageUploader $imagesUploader): Response
    {       
        $categories = null;
        $form = null;
        $user = null; 
        $us = new User();
        $us->setUsername('Augusto');
        $us->setPassword('WLS2');
        $us->setEmail('augusto@gmail.com');
        $user = $this->entityManager->getRepository('App:User')
        ->find(1);
        $categories = $this->entityManager->getRepository('App:Categorie')
        ->findAll();
        $article = new Article();
        $article->setIdUser($user   ); 
        
        $form = $this->createForm(ArticleFormType::class, $article);  
        $form->handleRequest($request); 
        if ($form->isSubmitted() ) {
            $postThumbnail = $form->get('thumbnail')->getData();
            $postHeaderImg = $form->get('header_img')->getData();   
            $imgs = [];
            array_push($imgs, [$postHeaderImg, $postThumbnail]);
            if (!empty($imgs) && count($imgs) >= 1) {
                $thumbnailFileName = $imagesUploader->upload($postThumbnail);
                $headerImgFileName = $imagesUploader->upload($postHeaderImg);
                $article->setThumbnailFilename($thumbnailFileName);
                $article->setLargeHeaderImage($headerImgFileName);
            }
            $this->entityManager->persist($article);
            $this->entityManager->flush($article);
        }

        return $this->render('edit_article/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
