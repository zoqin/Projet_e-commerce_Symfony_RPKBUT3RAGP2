<?php


namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use App\Enum\OrderStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $statuses = OrderStatus::cases();
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <= 10; $i++) {
            $order = new Order($this->getReference(UserFixtures::USER_REFERANCE.'_'.rand(1,10), User::class));
            $order->setStatus($statuses[array_rand($statuses)]);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
