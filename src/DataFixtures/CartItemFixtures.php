<?php

namespace App\DataFixtures;

use App\Entity\CartItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ProductFixtures;
use App\DataFixtures\ShoppingCartFixtures;

class CartItemFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {


            $cartItem = new CartItem();
            $cartItem->setProduct($this->getReference('product0'));
            $cartItem->setShoppingCart($this->getReference('shoppingCart0'));
            $cartItem->setQuantity(2);
            $manager->persist($cartItem);
            $manager->flush();

            
        }

       



        
    

    public function getDependencies()
    {
        return [
            ProductFixtures::class,
            ShoppingCartFixtures::class
            
        ];
    }
    }
    