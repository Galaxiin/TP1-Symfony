<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr-FR");
        
        for ($i=1; $i < 21; $i++) {
            // $product = new Product();
            $article = new Article();

            $libelle = $faker->sentence(3);
            $descrip = $faker->paragraph(20);
            $image = $faker->imageUrl(80,80,'technics');

            $article -> setLibelle($libelle);
            $article -> setPrix(mt_rand(50, 3000));
            $article -> setDescription($descrip);
            $article -> setImage($image);
            
            // $manager->persist($product);
            $manager->persist($article);
        }
        $manager->flush();
    }
}
