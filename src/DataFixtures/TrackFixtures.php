<?php

namespace App\DataFixtures;

use App\Entity\Track;
use App\Repository\TrackRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrackFixtures extends Fixture implements DependentFixtureInterface
{
    public const TRACKS = [
        [
            'title' => 'Tourner les serviettes',
            'notes' => 'E E E E F# E D D C# E E E E F# E D D C# E E E F# E Eb E B B A G# G# F# E E E E E E F# G# B A',
            'artist' => 'Patrick Sébastien',
            'picture' => 'rien.jpg',
            'difficulty' => 3,
        ],
        [
            'title' => 'Au clair de la lune',
            'notes' => 'G G G A B A G B A A G G G G A B A G B A A G A A A A E E A G F# F E D G G G A B A G B A A G',
            'artist' => null,
            'picture' => 'rien.jpg',
            'difficulty' => 2,
        ],
        [
            'title' => 'The Saints Go Marching In',
            'notes' => 'C E F G C E F G C E F G E C E D E E D C C E G G F F E F G E C D C',
            'artist' => null,
            'picture' => 'rien.jpg',
            'difficulty' => 2,
        ],
    ];
    private TrackRepository $trackRepository;

    public function __construct(TrackRepository $trackRepository)
    {
        $this->trackRepository = $trackRepository;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::TRACKS as $trackName) {
            $note = new Track();
            $note
                ->setTitle($trackName['title'])
                ->setNotes($trackName['notes'])
                ->setArtist($trackName['artist'])
                ->setPicture($trackName['picture'])
                ->setDifficulty($trackName['difficulty'])
                ->setCreator($this->getReference('user_' . rand(0, 1)));

            $manager->persist($note);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return
            [
                UserFixtures::class,
            ];
    }
}
