<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;
    
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
        [
            'title' => 'Arcane',
            'synopsis' => 'gay',
            'category' => 'Animation',
        ]
    ];

    public function __construct(SluggerInterface $slugger) {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $key => $currentProgram) {
            $program = new Program();
            $program->setTitle($currentProgram['title']);
            $slug = $this->slugger->slug($currentProgram['title']);
            $program->setSlug($slug);
            $program->setSynopsis($currentProgram['synopsis']);
            $program->setCategory($this->getReference('category_' . $currentProgram['category']));
            $program->setOwner($this->getReference('user_' . rand(1,2)));
            $manager->persist($program);
            $title = str_replace(' ', '', $currentProgram['title']);
            $this->addReference('program_' . $title, $program);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
