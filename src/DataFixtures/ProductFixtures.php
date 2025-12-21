<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public const PRODUCT_REFERENCE = 'product';
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 24; $i++) {
            $product = new Product();

            $product->setName('Product'. $i);
            $product->setPrice(rand(1, 100));
            $product->addImage($this->getReference(ImageFixtures::IMAGE_REFERENCE, Image::class));
            $product->addCategory($this->getReference(CategoryFixtures::CATEGORY_REFERANCE.'_'.rand(1, 3), Category::class));

            $hasDescription = rand(0,1);
            $product->setDescription($hasDescription ? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' : null);

            $hasStock = rand(0, 1);
            $product->setStock($hasStock ? rand(1, 25000) : 0, (bool) rand(0, 1));

            $manager->persist($product);

            $this->addReference(self::PRODUCT_REFERENCE.'_'.$i, $product);
        }
        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            CategoryFixtures::class,
            ImageFixtures::class,
        ];
    }
}