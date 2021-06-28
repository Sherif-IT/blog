<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\User;

class AppFixtures extends Fixture
{

    
    public function load(ObjectManager $manager)
    {
         /*
         $user = new User();
         $user->setUsername("marcus");
         $user->setPassword("ddd");
         $user->setEmail("marc@gmail.fr");
         $manager->persist($user);

         $art = new Article();
         $art->setThumbnailFilename("image.png");
         $art->setContenu("article test: lorem ipsum"); 
         $art->setTitre("test2");
         $art->setIdUser($user);
         $manager->persist($art);

        $manager->flush();*/
        
    }
}
