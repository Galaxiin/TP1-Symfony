<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr-FR");

        //Pour les users
        for ($i=1; $i < 11; $i++) {
            // $user = new User();
            $user = new User();

            $hash = $this->encoder->encodePassword($user, 'password');

            $user -> setPrenom($faker->firstname);
            $user -> setNom($faker->lastname);
            $user -> setAvatar($faker->imageUrl(80,80,'people'));
            $user -> setHash($hash); //password
            $user -> setIntroduction($faker->paragraph(2));
            $user -> setAdresseMail($faker->email);
            
            // $manager->persist($user);
            $manager->persist($user);
            $users[]=$user;
        }

        //Pour les articles
        for ($i=1; $i < 21; $i++) {
            // $product = new Product();
            $article = new Article();

            $libelle = $faker->sentence(3);
            $descrip = $faker->paragraph(20);
            $image = $faker->imageUrl(80,80,'technics');

            $user = $users[mt_rand(0, count($users) - 1)];

            $article -> setLibelle($libelle);
            $article -> setPrix(mt_rand(50, 3000));
            $article -> setDescription($descrip);
            $article -> setImage($image);
            $article -> setAuteur($user);
            
            // $manager->persist($product);
            $manager->persist($article);
        }        

        $manager->flush();
    }
}
