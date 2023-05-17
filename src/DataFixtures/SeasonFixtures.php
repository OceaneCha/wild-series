<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public const MAX_SEASONS = 5;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        foreach (ProgramFixtures::PROGRAMS as $program) {
            $seasonNumber = 1;

            while ($seasonNumber <= self::MAX_SEASONS) {
                $season = new Season();
                $season->setNumber($seasonNumber);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                
                $title = str_replace(' ', '', $program['title']);
                $season->setProgram($this->getReference('program_' . $title));

                $manager->persist($season);

                $this->addReference('season_' . $seasonNumber . '_' . $title, $season);
                $seasonNumber++;
            }
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
