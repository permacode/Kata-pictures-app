<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        //test user
        $user = new User;
        $user->setEmail('test@email.com')
            ->setPassword(
                $this->hasher->hashPassword($user, 'password')
            )
            ->setFirstname('User')
            ->setLastname('Testeur')
            ;
        $manager->persist($user);
        
        //admin
        $admin = new User;
        $admin->setEmail('admin@email.com')
                ->setPassword(
                    $this->hasher->hashPassword($admin, 'password')
                )
                ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
                ->setFirstname('Admin')
                ->setLastname('Admin')
                ;
        $manager->persist($admin);

        //other users
        for($i=0; $i < 400; $i++) 
        { 
            $user = (new User)
                    ->setEmail($this->faker->email())
                    ->setPassword('password')
                    ->setFirstname($this->faker->firstName())
                    ->setLastname($this->faker->lastName())
                    ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
