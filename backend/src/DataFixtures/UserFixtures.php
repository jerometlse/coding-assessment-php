<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture
{

    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('john Doe')
            ->setEmail('john@doe.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setApiKey('johnDoeApiKey');
        
        $manager->persist($user);
        $manager->flush();
    }
}
