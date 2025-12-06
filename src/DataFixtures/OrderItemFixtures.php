<?php


namespace App\DataFixtures;

use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderItemFixtures extends Fixture implements DependentFixtureInterface
{
    public const ORDER_ITEM_REFERENCE = 'order';
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $orderItem = new OrderItem($this->getReference(ProductFixtures::PRODUCT_REFERENCE.'_'.rand(1,10), Product::class));
            $orderItem->setQuantity(rand(1,10));
            $this->addReference(self::ORDER_ITEM_REFERENCE.'_'.$i, $orderItem);

            $manager->persist($orderItem);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            ProductFixtures::class
        ];
    }
}
