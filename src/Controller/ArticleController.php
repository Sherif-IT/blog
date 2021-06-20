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
         $userRepository = $entityManager->getRepository('App:User');
         /**$articlesRepository = $entityManager->getRepository('App:Article');
         $commentsRepository = $entityManager->getRepository('App:Commentaire');**/
     }

      /**
     * @Route("/blog/{id}", name="show_article")
     */
    public function show($id, Request $request)
    { 
        $categoryRepo = $this->entityManager->getRepository('App:Categorie'); 
        $article = $this->getDoctrine()
            ->getRepository(Article::class)->find($id);  
        $CaregoriesOfArticle = $article->getCategories();
        $categories = $categoryRepo->findAll();
        $relatedArticles = [];
        foreach ($CaregoriesOfArticle as $cat) {
            //TODO Exclure l'article courant des articles to show
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
            'controller_name' => 'BlogController',
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView(),
            'relatedArticles' => $relatedArticles,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/edit/blog", name="blog_choose_cat")
     */ 
    public function selectCategory(Request $request, ImageUploader $imagesUploader): Response
    {       
        $categories = null;
        $form = null;
        $user = null; 
        /*$us = new User();
        $us->setUsername('Augusto');
        $us->setPassword('Ltc44');
        $us->setEmail('augusto@gmail.com');*/
        $categories = $this->entityManager->getRepository('App:Categorie')
        ->findAll();
        $user = $this->entityManager->getRepository('App:User')
        ->find(1);
        $article = new Article();
        $article->setIdUser($user); 
        
        $form = $this->createForm(ArticleFormType::class, $article);  
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $postThumbnail = $form->get('thumbnail')->getData();
            if ($postThumbnail) {
                $thumbnailFileName = $imagesUploader->upload($postThumbnail);
                $article->setThumbnailFilename($thumbnailFileName);
            }
            $this->entityManager->persist($article);
            $this->entityManager->flush($article);
        }

        return $this->render('edit_article/index.html.twig', [
            'form' => $form->createView(),
        ]);

        
                    /*$categorie = new Categorie(); 
                    $categorie->addArticle($article);
                    $categorie->setCategorie($value->getCategorie());
                    $this->entityManager->persist($categorie);
                    $this->entityManager->flush($categorie);  }*/
                 // ... further modify the response or return it directly
          
    }

}
