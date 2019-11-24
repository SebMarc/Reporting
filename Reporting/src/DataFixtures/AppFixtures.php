<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Commande;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Magasin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public $userList = [];
    public $productList = [];

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // Création d'un admin
        $user = new User ();
        $user   ->setEmail('admin@admin.com')
                ->setRoles(['ROLE_ADMIN']);
        $password = $this->encoder->encodePassword($user, 'admin');
        $user   ->setPassword($password)
                ->setUsername('admin')
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setName('admin')
                ->setPhone($faker->phoneNumber())
                ->setEnable(true)
                ->setAdress($faker->streetAddress)
                ->setPostalCode($faker->numberBetween(1000, 9000) * 10)
                ->setCity($faker->city);
                $userList [] = $user;
      
        $manager->persist($user);

        // Création de 10 tech
        for($i = 0 ; $i <=9 ; $i++) {
            $user = new User ();
        $user   ->setEmail(sprintf('tech%d@teol.fr', $i))
                ->setRoles(['ROLE_TECH']);
        $password = $this->encoder->encodePassword($user, 'tech');
        $user   ->setPassword($password);
        $user   ->setUsername(sprintf('Technicien %d', $i))
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setName('')
                ->setPhone($faker->phoneNumber())
                ->setEnable(true)
                ->setAdress($faker->streetAddress)
                ->setPostalCode($faker->numberBetween(1000, 9000) * 10)
                ->setCity($faker->city);
                $userList [] = $user;

        $manager->persist($user)
        ;
        }


        //Création de 10 Members
        for($i = 0 ; $i <=4 ; $i++) {
        $customer = new User();
        $customer   ->setEmail(sprintf('member%d@member.fr', $i))
                    ->setRoles(['ROLE_MEMBER']);
        $password = $this->encoder->encodePassword($user, 'member');
        $customer   ->setPassword($password)
                    ->setUsername('')
                    ->setFirstname($faker->firstName())
                    ->setLastname($faker->lastName())
                    ->setName($faker->company())
                    ->setPhone($faker->phoneNumber())
                    ->setEnable(true)
                    ->setAdress($faker->streetAddress)
                    ->setPostalCode($faker->numberBetween(1000, 9000) * 10)
                    ->setCity($faker->city);
                    $userList [] = $customer;
                    $manager->persist($customer)
                    ;
        }   

        // Creation de 5 Products
        for($i = 0 ; $i <=4 ; $i++) {
            $product = new Product();
            $product    ->setName($faker->word);
            $productList[] = $product;
            $manager->persist($product)
            ;

        }

        // Creation de 5 commandes
        for($i = 0 ; $i <=4 ; $i++) {
            $order = new Commande();
            $order  ->setNumber($faker->numberBetween(1000, 9000))
                    ->setAmount($faker->numberBetween(1000, 9000));
            
                    //$randomproduct = $productList[mt_rand(0, count($productList)-1)];
            //$order  ->addProduct($randomproduct)
            $manager->persist($order)
            ;

        }

        // Creation de 5 categories
        for($i = 0 ; $i <=4 ; $i++) {
            $category = new Category();
            $category ->setName($faker->word);
            $manager->persist($category)
            ;
        }

        // Creation de 9 magasins
        for($i = 0 ; $i<= 4 ; $i++) {
            $shop = new Magasin();
            $shop   ->setName($faker->company())
            ->setAdress($faker->streetAddress())
            ->setPostalCode($faker->numberBetween(1000, 9000) * 10)
            ->setCity($faker->city())
            ->setPhone($faker->phoneNumber())
            ->setManager($faker->name())
            ->setClose($faker->dayOfWeek())
            ->setFax($faker->phoneNumber());
            $manager->persist($shop)
            ;
        }

        $manager->flush();
    }
}
