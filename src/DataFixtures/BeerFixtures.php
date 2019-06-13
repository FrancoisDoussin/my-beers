<?php

namespace App\DataFixtures;

use App\Entity\Beer;
use App\Service\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class BeerFixtures extends Fixture
{
    private $slugger;

    public function __construct(Slugger $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for($i=0; $i<10; $i++) {
            $beer = new Beer();
            $beer
                ->setName($faker->name)
                ->setSlug($this->slugger->slugify($beer->getName()))
                ->setPh($faker->randomFloat(2, 0, 1))
                ->setImageUrl('https://picsum.photos/200/300')
                ->setTagline($faker->text)
            ;
            $manager->persist($beer);
        }

        $manager->flush();
    }
}