<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public const MAX_ACTORS = 10;
    public const RAND_PROGRAMS = 3;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= self::MAX_ACTORS; $i++) {
            $actor = new Actor();

            $actor->setName($faker->firstName() . ' ' . $faker->lastName());

            $randPrograms = array_rand(ProgramFixtures::PROGRAMS, self::RAND_PROGRAMS);
            foreach ($randPrograms as $randProgram) {
                $programTitle = str_replace(' ', '', ProgramFixtures::PROGRAMS[$randProgram]['title']);
                $actor->addProgram($this->getReference('program_' . $programTitle));
            }
            $manager->persist($actor);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
