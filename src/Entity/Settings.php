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

    #[ORM\Column(length: 255)]
    private ?string $twitchChannel = null;

    #[ORM\Column(length: 255)]
    private ?string $youtubeChannel = null;

    #[ORM\Column(length: 255)]
    private ?string $profilTitle = null;

    #[ORM\Column(length: 1500)]
    private ?string $profilDescription = null;


    #[Vich\UploadableField(mapping: 'settings', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;


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

    public function getProfilTitle(): ?string
    {
        return $this->profilTitle;
    }

    public function setProfilTitle(string $profilTitle): self
    {
        $this->profilTitle = $profilTitle;

        return $this;
    }

    public function getProfilDescription(): ?string
    {
        return $this->profilDescription;
    }

    public function setProfilDescription(string $profilDescription): self
    {
        $this->profilDescription = $profilDescription;

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

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

}
