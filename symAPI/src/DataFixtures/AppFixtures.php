<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {}

    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setEmail('admin@devinci.fr');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'admin'));
        $user->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);

        for ($i = 2; $i <= 11; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@devinci.fr');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $user->setRoles(["ROLE_USER"]);

            $manager->persist($user);
        }


        $manager->flush();
    }
}
