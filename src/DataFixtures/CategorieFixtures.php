<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\User;

class CategorieFixtures extends Fixture
{
     /** @var EntityManagerInterface */
     private $entityManager;

     /** @var \Doctrine\Common\Persistence\ObjectRepository */
     private $userRepository;
 
     /** @var \Doctrine\Common\Persistence\ObjectRepository */
     private $articlesRepository;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $userRepository = $entityManager->getRepository('App:User');
        $articlesRepository = $entityManager->getRepository('App:Article');
        $commentsRepository = $entityManager->getRepository('App:Commentaire');
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("marco");
        $user->setPassword("ddd");
        $user->setEmail("arco@gmail.fr");
        $manager->persist($user);

        $art = new Article();
        $art->setContenu("article test: lorem ipsum"); 
        $art->setTitre("tttttttteeeestr");
        $art->setIdUser($user);
        $manager->persist($art);
         $categ = new Categorie();
         $categ->setCategorie('PHP'); 
         $categ->addArticle($art);
         $manager->persist($categ); 
        $cat = new Categorie();
        $cat->setCategorie("JAVA");
        $art->addCategory($cat);
        $manager->flush();
    }
}
