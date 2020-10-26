<?php

namespace App\DataFixtures;


use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker=Factory::create('FR-fr');
        

        for($i =1; $i <=30; $i++) {
                $ad=new Ad();

                $title=$faker->sentence();
 
                $coverImage=$faker->imageUrl(1000,350);
                $lintroduction=$faker->paragraph(2);
                $content='<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';


                $ad->setTitle($title)
                    ->setCoverImage($coverImage)
                    ->setIntroduction($lintroduction)
                    ->setContent($content)
                    ->setPrice(mt_rand(40,200))
                    ->setRooms(mt_rand(1,5));
                // $product = new Product();
                // $manager->persist($product);

                for($j = 1 ; $j <= mt_rand(2 , 5); $j++) {
                    $image= new Image();

                    $image->setUrl($faker->imageUrl())
                          ->setCaption($faker->sentence())
                          ->setAd($ad);

                         $manager->persist($image); 
                } 

                $manager->persist($ad);
        }
        $manager->flush();
    }
}
