<?php


namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <= 10; $i++) {
            $order = new Order($this->getReference(UserFixtures::USER_REFERANCE.'_'.rand(1,10), User::class));
            for ($j = 1; $j <= 3; $j++) {
                $order->setStatus($this->getReference(OrderItemFixtures::ORDER_ITEM_REFERENCE.'_'.rand(1,10), OrderItem::class));
            }
        }

        $manager->flush();
    }
}
