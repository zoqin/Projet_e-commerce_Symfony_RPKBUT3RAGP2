<?php


namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_REFERANCE = 'user';
    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();

            $user->setFirstName('prenom'.$i);
            $user->setLastName('nom'.$i);
            $user->setEmail('email'.$i.'@gmail.com');
            $user->setPassword(password_hash('password'.$i, PASSWORD_DEFAULT));
            $user->addAddress($this->getReference(AddressFixtures::ADDRESS_REFERENCE, Address::class));

            $manager->persist($user);

            $this->addReference(self::USER_REFERANCE.'_'.$i, $user);
        }

        $admin = new User();
        $admin->setFirstName('prenomAdmin');
        $admin->setLastName('nomAdmin');
        $admin->setEmail('admin@admin.com');
        $admin->setPassword(password_hash('password', PASSWORD_DEFAULT));

        $manager->flush();
    }
}