<?php

namespace App\DataFixtures;


use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker=Factory::create('FR-fr');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstName('Redha')
                  ->setLastName('Aoudia')
                  ->setEmail('redha@symfony.com')
                  ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                  ->setPicture('https://i.pinimg.com/originals/e9/ed/ff/e9edff15b3b9cb36a9f58de7c80cb824.jpg')
                  ->setIntroduction($faker->sentence())
                  ->setDescription('<p>' . join('<p></p>' , $faker->paragraphs(3)) . '</p>')
                  ->addUserRole($adminRole);
        $manager->persist($adminUser);        
                  
        


        //Nous gerons les utilisateurs
        $users =[];
        $genres = ['male','female'];


        for($i =1; $i <= 10; $i++){
            $user = new User();

            $genre =$faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits';
            $pictureId = $faker->numberBetween(1,99) . '.jpg';

           
           $picture .= ($genre == 'male' ? 'men/' : 'women/') .$pictureId; 

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstname($genre))
                 ->setLastName($faker->lastname)
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence())
                 ->setDescription('<p>' .join('</p><p>',$faker->paragraphs(3)) . '</p>')
                 ->setHash($hash)
                 ->setPicture($picture);

                 $manager->persist($user);
                 $users[]= $user;
        }
        
        //Nous gerons les annonces

        

        for($i =1; $i <=30; $i++) {
                $ad=new Ad();

                $title=$faker->sentence();
 
                $coverImage=$faker->imageUrl(1000,350);
                $lintroduction=$faker->paragraph(2);
                $content='<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

                $user = $users[mt_rand(0, count($users) - 1)];

                 $ad->setTitle($title)
                    ->setCoverImage($coverImage)
                    ->setIntroduction($lintroduction)
                    ->setContent($content)
                    ->setPrice(mt_rand(40,200))
                    ->setRooms(mt_rand(1,5))
                    ->setAuthor($user);

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
