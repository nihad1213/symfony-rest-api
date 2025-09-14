<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product;
        $product->setName('Product 1');
        $product->setSize(42);
        $product->setIsAvailable(true);
        $product->setPublishedOn(new \DateTime('2023-01-01'));
        $manager->persist($product);

        $product = new Product;
        $product->setName('Product 2');
        $product->setSize(36);
        $product->setIsAvailable(false);
        $product->setPublishedOn(new DateTime('2023-02-01'));
        $manager->persist($product);

        $product = new Product;
        $product->setName('Product 3');
        $product->setSize(48);
        $product->setIsAvailable(true);
        $product->setPublishedOn(new \DateTime('2023-03-01'));
        $manager->persist($product);
        $manager->flush();
    }
}
