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
    private ?string $youtubeChannel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTwitchChannel(): ?string
    {
        return $this->name_twitch;
    }

    public function setNameTwitch(string $name_twitch): self
    {
        $this->name_twitch = $name_twitch;

        return $this;
    }

    public function getYoutubeChannel(): ?string
    {
        return $this->youtubeChannel;
    }

    public function setYoutubeChannel(string $youtubeChannel): self
    {
        $this->youtubeChannel = $youtubeChannel;

        return $this;
    }
}
