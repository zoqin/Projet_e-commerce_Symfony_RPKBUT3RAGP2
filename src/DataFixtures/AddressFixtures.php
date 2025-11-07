<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture
{
    public const ADDRESS_REFERENCE = 'address';
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $address = new Address();
            $address->setCity('ville'.$i);
            $address->setStreet($i.'rue de la creuse');
            $address->setCountry('France');
            $address->setPostalCode(57000);
            $manager->persist($address);
        }

        $userAddress = new Address();
        $userAddress->setCity('CityTown');
        $userAddress->setStreet('Rue de la clientèle');
        $userAddress->setCountry('France');
        $userAddress->setPostalCode(57001);
        $manager->persist($userAddress);

        $manager->flush();

        $this->addReference(self::ADDRESS_REFERENCE, $userAddress);
    }
}