<?php

namespace App\DataFixtures;

use App\Entity\Note;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NoteFixtures extends Fixture
{
    public const NOTES = [
        ["name" => "C", "translation" => "Do", "frequency" => 261.6, "key" => "q"],
        ["name" => "C#", "translation" => "Do dièse", "frequency" => 277.2, 'key' => 'z'],
        ["name" => "D", "translation" => "Ré", "frequency" => 293.7, 'key' => 's'],
        ["name" => "Eb", "translation" => "Mi bémol", "frequency" => 311.1, 'key' => 'e'],
        ["name" => "E", "translation" => "Mi", "frequency" => 329.6, 'key' => 'd'],
        ["name" => "F", "translation" => "Fa", "frequency" => 349.2, 'key' => 'f'],
        ["name" => "F#", "translation" => "Fa dièse", "frequency" => 370.0, 'key' => 't'],
        ["name" => "G", "translation" => "Sol", "frequency" => 392.0, 'key' => 'g'],
        ["name" => "G#", "translation" => "Sol dièse", "frequency" => 415.3, 'key' => 'y'],
        ["name" => "A", "translation" => "La", "frequency" => 440.0, 'key' => 'h'],
        ["name" => "Bb", "translation" => "Si bémol", "frequency" => 466.2, 'key' => 'u'],
        ["name" => "B", "translation" => "Si", "frequency" => 493.9, 'key' => 'j'],
        ["name" => "C5", "translation" => "Do", "frequency" => 523.3, 'key' => 'k'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::NOTES as $noteName) {
            $note = new Note();
            $note
                ->setName($noteName['name'])
                ->setTranslation($noteName['translation'])
                ->setLetter($noteName['key'])
                ->setFrequency($noteName['frequency']);
            $manager->persist($note);
        }
        $manager->flush();
    }
}
