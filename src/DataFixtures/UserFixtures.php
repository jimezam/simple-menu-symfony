<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface) 
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['pepito@gmail.com', 'Pepito', 'Pimenton', 'hola123'],
            ['rosita@gmail.com', 'Rosita', 'Rosales', 'hola123'],
            ['armando@gmail.com', 'Armando', 'Casas', 'hola123']
        ];

        foreach ($usersData as [$email, $firstName, $lastName, $password]) {
            $user = new User();
            $user->setEmail($email);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setPassword(
                $this->userPasswordHasherInterface->hashPassword(
                    $user, $password
                )
            );
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
