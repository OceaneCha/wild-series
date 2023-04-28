<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $season = new Season();
        $season->setNumber(1);
        $season->setProgram($this->getReference('program_Arcane'));
        $season->setYear(2020);
        $season->setDescription('Blahblah');

        $manager->persist($season);

        $this->addReference('season1_Arcane', $season);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
