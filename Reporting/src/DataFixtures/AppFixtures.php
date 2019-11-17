<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Commande;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public $customerList = [];
    public $productList = [];

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // Création d'un admin et de 5 users
        $user = new User ();
        $user->setUsername('admin');
        $password = $this->encoder->encodePassword($user, 'admin');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail($faker->email());
        $manager->persist($user);

        for($i = 0 ; $i <=4 ; $i++) {
            $user = new User ();
        $user->setUsername($faker->name());
        $password = $this->encoder->encodePassword($user, 'user');
        $user->setPassword($password);
        $user->setEmail($faker->email());
        $manager->persist($user)
        ;
        }


        //Création de 5 Customers
        for($i = 0 ; $i <=4 ; $i++) {
        $customer = new Customer();
        $customer   ->setName($faker->company)
                    ->setFirstname($faker->firstName)
                    ->setLastname($faker->lastName)
                    ->setPhone($faker->phoneNumber)
                    ->setEmail($faker->email)
                    ->setEnable(true)
                    ->setAdress($faker->streetAddress)
                    ->setPostalCode('90000')
                    ->setCity($faker->city);
                    $password = $this->encoder->encodePassword($user, 'user');
                    $customer->setPassword($password);
                    $customerList[] = $customer;
                    $manager->persist($customer)
                    ;
        }   

        // Creation de 5 Products
        for($i = 0 ; $i <=4 ; $i++) {
            $product = new Product();
            $product    ->setName($faker->word);
                        $randomcustomer = $customerList[mt_rand(0, count($customerList)-1)];
            $product    ->addCustomer($randomcustomer);
            $productList[] = $product;
            $manager->persist($product)
            ;

        }

        // Creation de 5 commandes
        for($i = 0 ; $i <=4 ; $i++) {
            $order = new Commande();
            $order  ->setNumber('9000')
                    ->setAmount($faker->numberBetween(1000, 9000));
                    $randomcustomer = $customerList[mt_rand(0, count($customerList)-1)];
            $order  ->setCustomer($randomcustomer);
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

        
        
        


        $manager->flush();
    }
}
