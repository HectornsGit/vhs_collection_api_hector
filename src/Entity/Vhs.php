<?php

namespace App\Entity;

use App\Repository\VhsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VhsRepository::class)]
class Vhs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $collection_name = null;

    #[ORM\Column]
    private ?int $moviedb_id = null;

    #[ORM\Column(length: 100)]
    private ?string $original_title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCollectionName(): ?string
    {
        return $this->collection_name;
    }

    public function setCollectionName(string $collection_name): static
    {
        $this->collection_name = $collection_name;

        return $this;
    }

    public function getMoviedbId(): ?int
    {
        return $this->moviedb_id;
    }

    public function setMoviedbId(int $moviedb_id): static
    {
        $this->moviedb_id = $moviedb_id;

        return $this;
    }

    public function getOriginalTitle(): ?string
    {
        return $this->original_title;
    }

    public function setOriginalTitle(string $original_title): static
    {
        $this->original_title = $original_title;

        return $this;
    }
}
