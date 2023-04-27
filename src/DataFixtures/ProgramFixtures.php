<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        [
            'title' => 'Black Mirror',
            'synopsis' => 'wow',
            'category' => 'Horreur',
        ],
        [
            'title' => 'Friends',
            'synopsis' => 'wow',
            'category' => 'Comédie',
        ],
        [
            'title' => 'The 100',
            'synopsis' => 'wow',
            'category' => 'Sci-Fi',
        ],
        [
            'title' => 'SHIELD',
            'synopsis' => 'wow',
            'category' => 'Aventure',
        ],
        [
            'title' => 'Dark',
            'synopsis' => 'wow',
            'category' => 'Horreur',
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $key => $currentProgram) {
            $program = new Program();
            $program->setTitle($currentProgram['title']);
            $program->setSynopsis($currentProgram['synopsis']);
            $program->setCategory($this->getReference('category_' . $currentProgram['category']));
            $manager->persist($program);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
