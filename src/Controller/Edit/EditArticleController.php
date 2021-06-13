<?php

namespace App\Controller\Edit;

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


class EditArticleController extends AbstractController
{
    
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $userRepository;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        //$userRepository = $entityManager->getRepository('App:User');
        //$articlesRepository = $entityManager->getRepository('App:Article');
        //$commentsRepository = $entityManager->getRepository('App:Commentaire');
    }
     /**
     * @Route("/choose-category/blog", name="blog_choose_cat")
     */ 
    public function selectCategory(Request $request): Response
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
          
        return $this->render('edit_article/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    /** 
     * @ParamConverter("_categories", class="App\Entity\Categorie:categorie")
     * */
    #[Route('/edit-article/blog ', name: 'blog_edit')]
    public function editArticle(Categorie $_categories, Request $request): Response
    {     
       /* $form = null;
        $user = null; 
        $user = $this->entityManager->getRepository('App:User')
        ->find(3);
        $article = new Article();
        $article->setIdUser($user);  
        foreach ($_categories as $key => $value) {
            $article->setCategorie($value->getCategorie());
        }
        $form = $this->createForm(ArticleFormType::class, $article);  
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $this->entityManager->persist($article);
            $this->entityManager->flush($article);
        }
        return $this->render('edit_article/index.html.twig', [
            'form' => $form->createView(),
        ]);*/

    }
}


