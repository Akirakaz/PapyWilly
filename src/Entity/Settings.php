<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_twitch = null;

    #[ORM\Column(length: 255)]
    private ?string $name_youtube = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTwitch(): ?string
    {
        return $this->name_twitch;
    }

    public function setNameTwitch(string $name_twitch): self
    {
        $this->name_twitch = $name_twitch;

        return $this;
    }

    public function getNameYoutube(): ?string
    {
        return $this->name_youtube;
    }

    public function setNameYoutube(string $name_youtube): self
    {
        $this->name_youtube = $name_youtube;

        return $this;
    }
}
