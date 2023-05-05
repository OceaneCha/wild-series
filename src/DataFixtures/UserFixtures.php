<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User;
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $pwd = $this->hasher->hashPassword($admin, 'admin');
        $admin->setPassword($pwd);
        $this->addReference('user_1', $admin);
        $manager->persist($admin);

        $contributor = new User;
        $contributor->setEmail('user@example.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $pwd = $this->hasher->hashPassword($contributor, 'user');
        $contributor->setPassword($pwd);
        $this->addReference('user_2', $contributor);
        $manager->persist($contributor);

        $manager->flush();
    }
}
