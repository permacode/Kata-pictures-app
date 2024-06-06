<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct(
        private UserRepository $userRepository
    )
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $users = $this->userRepository->findAll();

        for($i=0; $i < 300; $i++) 
        { 
            $picture = new Picture;
            $picture->setUser(
                        $this->faker->randomElement($users)
                    )
                    ->setFileName('https://picsum.photos/500/500')
                    ->setCreatedAt(new DateTimeImmutable())
                    ->setUpdatedAt(new DateTimeImmutable())
                    ;

            $manager->persist($picture);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
