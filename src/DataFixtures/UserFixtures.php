<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // creating one admin user
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'adminpassword'
        );
        $user
            ->setEmail('g.hartemann@gmail.com')
            ->setPassword($hashedPassword)
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $this->addReference('user_0', $user);

        // creating 10 users
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                '123456'
            );
            $user
                ->setEmail($faker->email())
                ->setPassword($hashedPassword)
                ->setRoles(['ROLE_SYNTHER']);
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
