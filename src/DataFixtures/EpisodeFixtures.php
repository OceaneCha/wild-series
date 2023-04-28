<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public const MAX_EPISODES = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (ProgramFixtures::PROGRAMS as $program) {
            $seasonNumber = 1;
            $title = str_replace(' ', '', $program['title']);

            while ($seasonNumber <= SeasonFixtures::MAX_SEASONS) {
                for ($i = 1; $i <= self::MAX_EPISODES; $i++) {
                    $episode = new Episode();
                    $episode->setTitle($faker->sentence());
                    $episode->setNumber($i);
                    $episode->setSeason($this->getReference('season_' . $seasonNumber . '_' . $title));
                    $episode->setSynopsis($faker->paragraphs(3, true));
        
                    $manager->persist($episode);
                }

                $seasonNumber++;
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
