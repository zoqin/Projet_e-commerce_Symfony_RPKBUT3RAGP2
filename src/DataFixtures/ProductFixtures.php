<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public const PRODUCT_REFERANCE = 'product';
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10; $i++) {
            $product = new Product();

            $product->setName('Product ' . $i);
            $product->setPrice(rand(1, 100));
            $product->addImage($this->getReference(ImageFixtures::IMAGE_REFERENCE, Image::class));
            $product->addCategory($this->getReference(CategoryFixtures::CATEGORY_REFERANCE.'_'.rand(1, 3), Category::class));

            $this->addReference(self::PRODUCT_REFERANCE.'_'.$i, $product);

            $manager->persist($product);
        }
        $manager->flush();
    }
}