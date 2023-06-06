<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Doctrine\SlugListener;
use App\Doctrine\TimestampListener;
use App\Entity\Traits\ActorTrait;
use App\Entity\Traits\TimestampTrait;
use App\Helper\ResponseGroups;
use App\Repository\UserTargetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserTargetRepository::class)]
#[ORM\EntityListeners([
    TimestampListener::class,
    SlugListener::class
])]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource]
class UserTarget
{
    use TimestampTrait;
    use ActorTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([ResponseGroups::GROUP_USER_TARGET_VIEW])]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups([ResponseGroups::GROUP_USER_TARGET_VIEW, ResponseGroups::GROUP_USER_TARGET_WRITE])]
    private ?int $exportType = null;

    #[ORM\Column(length: 255)]
    #[Groups([ResponseGroups::GROUP_USER_TARGET_VIEW, ResponseGroups::GROUP_USER_TARGET_WRITE])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups([ResponseGroups::GROUP_USER_TARGET_VIEW, ResponseGroups::GROUP_USER_TARGET_WRITE])]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Groups([ResponseGroups::GROUP_USER_TARGET_VIEW, ResponseGroups::GROUP_USER_TARGET_WRITE])]
    private ?string $targetUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExportType(): ?int
    {
        return $this->exportType;
    }

    public function setExportType(int $exportType): self
    {
        $this->exportType = $exportType;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTargetUrl(): ?string
    {
        return $this->targetUrl;
    }

    public function setTargetUrl(string $targetUrl): self
    {
        $this->targetUrl = $targetUrl;

        return $this;
    }
}
