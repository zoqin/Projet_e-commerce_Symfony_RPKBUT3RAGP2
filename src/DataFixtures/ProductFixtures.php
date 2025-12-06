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
        for($i = 1; $i <= 10; $i++) {
            $product = new Product();

            $product->setName('Product'. $i);
            $product->setPrice(rand(1, 100));
            $product->addImage($this->getReference(ImageFixtures::IMAGE_REFERENCE, Image::class));
            $product->addCategory($this->getReference(CategoryFixtures::CATEGORY_REFERANCE.'_'.rand(1, 3), Category::class));
            $product->setStock(rand(0, 25000));

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