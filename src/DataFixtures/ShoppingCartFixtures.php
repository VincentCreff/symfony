<?php

namespace App\DataFixtures;

use App\Entity\ShoppingCart;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ProductFixtures;

class ShoppingCartFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {


        $shoppingCart = new ShoppingCart();
        $shoppingCart->setTotal($this->getReference('product0')->getPrice() + $this->getReference('product1')->getPrice() + $this->getReference('product2')->getPrice());
        $shoppingCart->addProduct($this->getReference('product0'));
        $shoppingCart->addProduct($this->getReference('product1'));
        $shoppingCart->addProduct($this->getReference('product2'));
        $this->addReference('shoppingCart0', $shoppingCart);
        $manager->persist($shoppingCart);


    

        
        $shoppingCart2 = new ShoppingCart();
        $shoppingCart2->setTotal($this->getReference('product3')->getPrice() + $this->getReference('product4')->getPrice() + $this->getReference('product5')->getPrice());
        $shoppingCart2->addProduct($this->getReference('product3'));
        $shoppingCart2->addProduct($this->getReference('product4'));
        $shoppingCart2->addProduct($this->getReference('product5'));
        $this->addReference('shoppingCart1', $shoppingCart);
        $manager->persist($shoppingCart2);


        $manager->flush();


    }
    public function getDependencies()
    {
        return [
            ProductFixtures::class,
        ];
}
}