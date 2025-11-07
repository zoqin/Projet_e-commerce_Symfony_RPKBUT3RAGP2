<?php


namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstName('prenom'.$i);
            $user->setLastName('nom'.$i);
            $user->setEmail('email'.$i.'@gmail.com');
            $user->addAddress($this->getReference(AddressFixtures::ADDRESS_REFERENCE, Address::class));
            $manager->persist($user);
        }

        $manager->flush();
    }
}