<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Recette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i <20; $i++) { 
            
            $recette = new Recette();

            $recette->setTitle($faker->catchPhrase)
                    ->setSoustitres($faker->paragraphs(2, true))
                    ->setIngredient($faker->paragraphs(mt_rand(1, 3), true))
            ;

            $manager->persist($recette);

        }

        $manager->flush();
    }
}
