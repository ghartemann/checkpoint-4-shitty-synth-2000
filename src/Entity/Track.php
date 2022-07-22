<?php

namespace App\Entity;

use App\Repository\TrackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
class Track
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        max: 255,
        maxMessage: 'The title cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\Length(
        max: 255,
        maxMessage: 'The artist\'s name cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $artist = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        max: 255,
        maxMessage: 'The URL cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Url(message: 'The url {{ value }} is not a valid url',)]
    #[ORM\Column(length: 255)]
    private ?string $picture = "https://www.wmhbradio.org/wp-content/uploads/2016/07/music-placeholder.png";

    #[Assert\NotBlank]
    #[Assert\Length(
        max: 255,
        maxMessage: 'You can\'t have more than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $notes = null;

    #[Assert\NotBlank]
    #[Assert\Range(
        notInRangeMessage: 'The difficulty must be between 1 and 3',
        min: 1,
        max: 3,
    )]
    #[ORM\Column]
    private ?int $difficulty = null;

    #[ORM\ManyToOne(inversedBy: 'tracks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favorites', cascade: ['persist'])]
    private Collection $favouriters;

    #[Assert\NotBlank]
    #[Assert\Length(
        max: 255,
        maxMessage: 'You can\'t have more than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $letters = null;

    #[Assert\Length(
        max: 255,
        maxMessage: 'The URL cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtube = null;

    public function __construct()
    {
        $this->favouriters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(?string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavouriters(): Collection
    {
        return $this->favouriters;
    }

    public function addFavouriter(User $favouriter): self
    {
        if (!$this->favouriters->contains($favouriter)) {
            $this->favouriters[] = $favouriter;
        }

        return $this;
    }

    public function removeFavouriter(User $favouriter): self
    {
        $this->favouriters->removeElement($favouriter);

        return $this;
    }

    public function getLetters(): ?string
    {
        return $this->letters;
    }

    public function setLetters(string $letters): self
    {
        $this->letters = $letters;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }
}
