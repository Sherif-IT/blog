<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\User;
use App\Entity\Tag;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    { 
        $user = new User();
        $user->setUsername("marco");
        $user->setPassword("ddd");
        $user->setEmail("arco@gmail.fr");
        $manager->persist($user); 
        /*$art = new Article();
        $art->setThumbnailFilename("image.png");
        $art->setContenu("article test: lorem ipsum"); 
        $art->setTitre("test1 ");
        $art->setIdUser($user);
        $manager->persist($art);*/
        $categories = ['PHP', 'JAVA', 'Python', 'Adobe Commerce', 'Réseaux et Cyber security', 'Front End development'];
        foreach ($categories as $categorie) { 
            $_categ = new Categorie();
            $_categ->setCategorie($categorie);  
            $manager->persist($_categ);  
            $manager->flush();
        }   
        $tags = ['web development', 'Agile', 'Spring', 'MVC', 'Big Data', 'développement web', 'Jango', 'robotics', 'IA'];
        foreach ($tags as $tag) {
            $_tag = new Tag(); 
            $_tag->setTag($tag);     
            $manager->persist($_tag);     
            $manager->flush();
        } 
    }
}
    
