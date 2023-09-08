<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Specialist;
use App\Factory\CustomerFactory;
use App\Factory\SpecialistFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        

        SpecialistFactory::createMany(5);
        SpecialistFactory::createOne(['email' => '', 'password' =>'']);
        CustomerFactory::createMany(50, function() {return ['specialist' => SpecialistFactory::random()]; });


        $manager->flush();
    }
}
