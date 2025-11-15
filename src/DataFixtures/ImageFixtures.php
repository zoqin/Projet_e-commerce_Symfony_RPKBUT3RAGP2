<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    public const IMAGE_REFERENCE = 'image';
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 10; $i++) {
            $image = new Image();
            $image->setUrl('https://static.satisfactory-calculator.com/img/gameStable1.0/IconDesc_Concrete_256.png?v=17252865'.$i);
            $manager->persist($image);

        }

        $imageExemple = new Image();
        $imageExemple->setUrl('https://static.satisfactory-calculator.com/img/gameStable1.0/IconDesc_TimeCrystal_256.png?v=1725286509');
        $manager->persist($imageExemple);

        $manager->flush();

        $this->addReference(self::IMAGE_REFERENCE, $imageExemple);
    }
}