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
    private ?string $twitchChannel = null;

    #[ORM\Column(length: 255)]
    private ?string $youtubeChannel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTwitchChannel(): ?string
    {
        return $this->twitchChannel;
    }

    public function setTwitchChannel(string $twitchChannel): self
    {
        $this->twitchChannel = $twitchChannel;

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
