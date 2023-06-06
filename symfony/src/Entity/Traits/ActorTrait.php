<?php

namespace App\Entity\Traits;

use App\Entity\User;
use App\Helper\ResponseGroups;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


trait ActorTrait
{

    #[MaxDepth(2)]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Blameable(on: 'create')]
    #[Groups([
        ResponseGroups::GROUP_USER_TARGET_VIEW,
    ])]
    private  $createdBy;

    #[MaxDepth(2)]
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Blameable(on: 'update')]
    #[Groups([
        ResponseGroups::GROUP_USER_TARGET_VIEW,
    ])]
    private  $updatedBy;


    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setUpdatedBy(?User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }


}