<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $episode = new Episode();
        $episode->setTitle('Welcome to the Playground');
        $episode->setNumber(1);
        $episode->setSeason($this->getReference('season1_Arcane'));
        $episode->setSynopsis('Blah blah');

        $manager->persist($episode);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
