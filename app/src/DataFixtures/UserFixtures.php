<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;
    
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $manager->persist($this->getUserAdmin());
        $manager->persist($this->getUserPage1());
        $manager->persist($this->getUserPage2());
        $manager->flush();
    }

    private function getUserAdmin()
    {
        $user = new User();

        $user->setName('Admin');
        $user->setUsername('admin');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'adminpassword'
        ));
        $user->setRoles(['ROLE_ADMIN']);

        return $user;
    }

    private function getUserPage1()
    {
        $user = new User();

        $user->setName('Page 1');
        $user->setUsername('page1');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'page1password'
        ));
        $user->setRoles(['ROLE_PAGE_1']);

        return $user;
    }

    private function getUserPage2()
    {
        $user = new User();

        $user->setName('Page 2');
        $user->setUsername('page2');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'page2password'
        ));
        $user->setRoles(['ROLE_PAGE_2']);

        return $user;
    }
}
