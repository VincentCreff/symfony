<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    
    public function load(ObjectManager $manager): void
    {
  
        for ($i = 0; $i < 2; $i++) {
            $category = new Category();
            $category->setName('Category '. $i);
            $manager->persist($category);

            $this->addReference('category'. $i, $category);
        }

        $manager->flush();
    
    }
}
