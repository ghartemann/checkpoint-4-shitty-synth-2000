<?php

namespace App\DataFixtures;

use App\Entity\Track;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrackFixtures extends Fixture implements DependentFixtureInterface
{
    public const TRACKS = [
        [
            'title' => 'Tourner les serviettes',
            'notes' => 'E E E E F# E D D C# E E E E F# E D D C# E E E F# E Eb E B B A G# G# F# E E E E E E F# G# B A',
            'letters' => 'TODO',
            'artist' => 'Patrick Sébastien',
            'picture' => 'serviettes.jpeg',
            'difficulty' => 3,
            'youtube' => 'kk2CzGfL7n4',
        ],
        [
            'title' => 'Au clair de la lune',
            'notes' => 'G G G A B A G B A A G G G G A B A G B A A G A A A A E E A G F# F E D G G G A B A G B A A G',
            'letters' => 'TODO',
            'artist' => null,
            'picture' => 'lune.jpg',
            'difficulty' => 2,
            'youtube' => 'IYLTc3tGdzc',
        ],
        [
            'title' => 'The Saints Go Marching In',
            'notes' => 'C E F G C E F G C E F G E C E D E E D C C E G G F F E F G E C D C',
            'letters' => 'TODO',
            'artist' => "Treme Brass Band",
            'picture' => 'treme.jpeg',
            'difficulty' => 2,
            'youtube' => 'kCKfUgnpN48',
        ],
        [
            'title' => 'Le petit bonhomme en mousse',
            'notes' => 'C A G F E F C C B A G F E F D D Bb A G F# G C5 C5 C5 C5 C5 C5 Bb G F',
            'letters' => 'TODO',
            'artist' => "Patrick Sébastien",
            'picture' => 'petit-bonhomme.jpeg',
            'difficulty' => 3,
            'youtube' => "fAmvQ8C2SUo",
        ],
        [
            'title' => 'The Aristocats',
            'notes' => 'C E G E C E G E F A C5 A C5 C5 B A G F E D C D E D E D C C',
            'letters' => 'TODO',
            'artist' => 'Walt Disney',
            'picture' => 'cats.jpg',
            'difficulty' => 2,
            'youtube' => 'tEL-RsUsKlw',
        ],
        [
            'title' => 'Happy Birthday to You',
            'notes' => 'C C D C F E C C D C G F C C C5 A F E D Bb Bb A F G F',
            'letters' => 'TODO',
            'artist' => null,
            'picture' => 'birthday.jpg',
            'difficulty' => 3,
            'youtube' => '_z-1fTlSDF0',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $i = 0;

        foreach (self::TRACKS as $trackName) {
            $note = new Track();
            $note
                ->setTitle($trackName['title'])
                ->setNotes($trackName['notes'])
                ->setLetters($trackName['letters'])
                ->setArtist($trackName['artist'])
                ->setPicture($trackName['picture'])
                ->setDifficulty($trackName['difficulty'])
                ->setYoutube($trackName['youtube'])
                ->setCreator($this->getReference('user_' . rand(1, 11)))
                ->addFavouriter($this->getReference('user_' . rand(0, 1)));
            $manager->persist($note);
            $i++;
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
