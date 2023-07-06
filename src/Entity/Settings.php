<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
#[Vich\Uploadable]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, unique: true)]
    private ?string $settingKey = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtubeChannel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $aboutTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $aboutDescription = null;

    #[Vich\UploadableField(mapping: 'settings', fileNameProperty: 'aboutImage')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $aboutImage = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $channelDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $channelCountry = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $channelPlatforms = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $channelGames = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYoutubeChannel(): ?string
    {
        return $this->youtubeChannel;
    }

    public function setYoutubeChannel(?string $youtubeChannel): self
    {
        $this->youtubeChannel = $youtubeChannel;

        return $this;
    }

    public function getAboutTitle(): ?string
    {
        return $this->aboutTitle;
    }

    public function setAboutTitle(?string $aboutTitle): self
    {
        $this->aboutTitle = $aboutTitle;

        return $this;
    }

    public function getAboutDescription(): ?string
    {
        return $this->aboutDescription;
    }

    public function setAboutDescription(?string $aboutDescription): self
    {
        $this->aboutDescription = $aboutDescription;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setAboutImage(?string $aboutImage): void
    {
        $this->aboutImage = $aboutImage;
    }

    public function getAboutImage(): ?string
    {
        return $this->aboutImage;
    }

    public function getChannelDescription(): ?string
    {
        return $this->channelDescription;
    }

    public function setChannelDescription(?string $channelDescription): self
    {
        $this->channelDescription = $channelDescription;

        return $this;
    }

    public function getChannelCountry(): ?string
    {
        return $this->channelCountry;
    }

    public function setChannelCountry(?string $channelCountry): self
    {
        $this->channelCountry = $channelCountry;

        return $this;
    }

    public function getChannelPlatforms(): ?string
    {
        return $this->channelPlatforms;
    }

    public function setChannelPlatforms(?string $channelPlatforms): self
    {
        $this->channelPlatforms = $channelPlatforms;

        return $this;
    }

    public function getChannelGames(): ?string
    {
        return $this->channelGames;
    }

    public function setChannelGames(?string $channelGames): self
    {
        $this->channelGames = $channelGames;

        return $this;
    }

    public function getSettingKey(): ?string
    {
        return $this->settingKey;
    }

    public function setSettingKey(?string $settingKey): self
    {
        $this->settingKey = $settingKey;

        return $this;
    }
}
