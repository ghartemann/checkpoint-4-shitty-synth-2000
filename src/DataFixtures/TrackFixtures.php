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
            'letters' => 'D D D D T D S S Z D D D D T D S S Z D D D T D E D J J H Y Y T D D D D D T Y J H',
            'artist' => 'Patrick Sébastien',
            'picture' => 'https://www.bide-et-musique.com/images/pochettes/20536.jpg',
            'difficulty' => 3,
            'youtube' => 'kk2CzGfL7n4',
        ],
        [
            'title' => 'Au clair de la lune',
            'notes' => 'G G G A B A G B A A G G G G A B A G B A A G A A A A E E A G F# E D G G G A B A G B A A G',
            'letters' => 'G G G H J H G J H H G G G G H J H G J H H G H H H H D D H G T D S G G G H J H G J H H G',
            'artist' => null,
            'picture' => 'https://i.ytimg.com/vi/yN38P4DypUo/maxresdefault.jpg',
            'difficulty' => 2,
            'youtube' => 'IYLTc3tGdzc',
        ],
        [
            'title' => 'The Saints Go Marching In',
            'notes' => 'C E F G C E F G C E F G E C E D E E D C C E G G F F E F G E C D C',
            'letters' => 'Q D F G Q D F G Q D F G D Q D S D D S Q Q D G G F F D F G D Q S Q',
            'artist' => "Treme Brass Band",
            'picture' => 'https://m.media-amazon.com/images/I/71D0dkAz4qL._SS500_.jpg',
            'difficulty' => 2,
            'youtube' => 'kCKfUgnpN48',
        ],
        [
            'title' => 'Le petit bonhomme en mousse',
            'notes' => 'C A G F E F C C A G F E F D D Bb A G F# G C5 C5 C5 C5 C5 C5 Bb G F',
            'letters' => 'Q H G F D F Q Q H G F D F S S U H G T G K K K K K K U G F',
            'artist' => "Patrick Sébastien",
            'picture' => 'https://fr.shopping.rakuten.com/photo/991771788_L.jpg',
            'difficulty' => 3,
            'youtube' => "fAmvQ8C2SUo",
        ],
        [
            'title' => 'The Aristocats',
            'notes' => 'C E G E C E G E F A C5 A C5 C5 B A G F E D C D E D E D C C',
            'letters' => 'Q D G D Q D G D F H K H K K J H G F D S Q S D S D S Q Q',
            'artist' => 'Walt Disney',
            'picture' => 'https://m.media-amazon.com/images/I/51ZNS9CB30L.jpg',
            'difficulty' => 2,
            'youtube' => 'tEL-RsUsKlw',
        ],
        [
            'title' => 'Happy Birthday to You',
            'notes' => 'C C D C F E C C D C G F C C C5 A F E D Bb Bb A F G F',
            'letters' => 'Q Q S Q F D Q Q S Q G F Q Q K H F D S U U H F G F',
            'artist' => null,
            'picture' => 'https://cdns-images.dzcdn.net/images/cover/e620bddf88338269999ff1b8b0381c4a/350x350.jpg',
            'difficulty' => 3,
            'youtube' => null,
        ],
        [
            'title' => 'Running Up That Hill',
            'notes' => 'Eb Bb Bb Bb Bb G Eb Bb Bb Bb Bb D C Bb Bb Bb Bb G Bb C Bb Bb Bb Bb G G F Eb F Eb',
            'letters' => 'E U U U U G E U U U U S Q U U U U G U Q U U U U G G F E F E',
            'artist' => 'Kate Bush',
            'picture' => 'https://m.media-amazon.com/images/I/71QN-MHfywL._SX355_.jpg',
            'difficulty' => 3,
            'youtube' => "wp43OdtAAkM",
        ],
        [
            'title' => 'Never Gonna Give You Up',
            'notes' => 'C D F D A A G C D F D G G F E D C D F D F G E D C C G F',
            'letters' => 'Q S F S H H G Q S F S G G F D S Q S F S F G D S Q Q G F',
            'artist' => 'Rick Astley',
            'picture' => 'https://fr.shopping.rakuten.com/photo/975883067.jpg',
            'difficulty' => 2,
            'youtube' => 'dQw4w9WgXcQ',
        ],
        [
            'title' => 'Don\'t Stop Me Now',
            'notes' => 'E F G C5 E E D D C D E D E E G E',
            'letters' => 'D F G K D D S S Q S D S D D G D',
            'artist' => 'Queen',
            'picture' => 'https://cdns-images.dzcdn.net/images/cover/9d5f6e56b755d104525cf3a0810356bc/500x500.jpg',
            'difficulty' => 2,
            'youtube' => 'HgzGwKwLmgM',
        ],


    ];

    public function load(ObjectManager $manager): void
    {
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
                ->setCreator($this->getReference('user_' . rand(1, 10)));
            for ($i = 0; $i <= rand(0, 4); $i++) {
                $note->addFavouriter($this->getReference('user_' . rand(1, 10)));
            }
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
