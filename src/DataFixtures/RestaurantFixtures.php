<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RestaurantFixtures extends Fixture implements DependentFixtureInterface
{
    protected Array $users = [];

    public function load(ObjectManager $manager): void
    {
        $restaurant = new Restaurant();
        $restaurant->setName("La Casa de Pepe");
        $restaurant->setSlogan("¡El sabor de Colombia!");
        $restaurant->setSlug("la-casa-de-pepe");
        $restaurant->setAddress("Calle 123 # 45-67");
        $restaurant->setCity("Manizales");
        $restaurant->setProvince("Caldas");
        $restaurant->setCountry("Colombia");
        $restaurant->setPhone("3000102030");
        $restaurant->setWhatsapp("3000102031");
        $restaurant->setWebsite("https://lacasadpepe.com");
        $restaurant->setInstagram("lacasadpepe");
        $restaurant->setLatitude(5.0689);
        $restaurant->setLongitude(-75.5174);
        $restaurant->setOwner($this->getRandomUser($manager));
        $restaurant->setActiveMenu(null);
        $manager->persist($restaurant);

        $manager->flush();
    }

    public function getDependencies() : array
    {
        return [
            UserFixtures::class,
        ];
    }

    protected function loadUsers(ObjectManager $manager) : void
    {
        if(!empty($this->users))
            return;

        // Obtener los IDs de los usuarios persistidos usando QueryBuilder
        $userRepository = $manager->getRepository(User::class);

        // Usamos el QueryBuilder para traer los usuarios
        $this->users = $userRepository->createQueryBuilder('u')
            ->select('u')
            ->getQuery()
            ->getResult();
    }

    protected function getRandomUser(ObjectManager $manager) : ?User
    {
        $this->loadUsers($manager);

        if(empty($this->users))
            return null;

        return $this->users[array_rand($this->users)];
    }
}
