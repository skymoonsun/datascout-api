<?php

namespace App\Entity\Traits;

use App\Helper\ResponseGroups;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\DBAL\Types\Types;


trait TimestampTrait
{

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        ResponseGroups::GROUP_USER_TARGET_VIEW,
    ])]
    private ?\DateTimeInterface $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([
        ResponseGroups::GROUP_USER_TARGET_VIEW,
    ])]
    private ?\DateTimeInterface $updatedAt;


    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {

        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        if (!isset($this->createdAt)) {
            $this->createdAt = new DateTime();
        }

        if (!isset($this->updatedAt)) {
            $this->setUpdatedAt(new DateTime());
        }
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }
}