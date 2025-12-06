<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERANCE = 'category';
    public function load(ObjectManager $manager): void
    {
        $categoryType = [
            'Batiment',
            'Ressources',
            'Collectible'
        ];

        foreach($categoryType as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);

            $this->addReference(self::CATEGORY_REFERANCE.'_'.($key+1), $category);
        }
        $manager->flush();
    }
}