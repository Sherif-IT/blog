<?php

namespace App\DataFixtures;
 
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tag; 
use App\Entity\User;

class TagFixtures extends Fixture 
{

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername("mario");
        $user->setPassword("ddd");
        $user->setEmail("ario@gmail.fr");
        $manager->persist($user);
        $tags = ['web development', 'Agile', 'Spring', 'MVC', 'Big Data', 'développement web', 'Jango', 'robotics', 'IA'];
        foreach ($tags as $tag) {
            $_tag = new Tag(); 
            $_tag->setTag($tag);     
            $manager->persist($_tag);     
            $manager->flush();
        } 
    }

   
}
