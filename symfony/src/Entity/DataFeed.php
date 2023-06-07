<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Doctrine\TimestampListener;
use App\Entity\Traits\ActorTrait;
use App\Entity\Traits\TimestampTrait;
use App\Helper\ResponseGroups;
use App\Repository\DataFeedRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DataFeedRepository::class)]
#[ORM\EntityListeners([
    TimestampListener::class
])]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource]
class DataFeed
{
    use TimestampTrait;
    use ActorTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([ResponseGroups::GROUP_DATA_FEED_VIEW])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'dataFeeds')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([ResponseGroups::GROUP_DATA_FEED_VIEW, ResponseGroups::GROUP_DATA_FEED_WRITE])]
    private ?UserTarget $target = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarget(): ?UserTarget
    {
        return $this->target;
    }

    public function setTarget(?UserTarget $target): self
    {
        $this->target = $target;

        return $this;
    }
}
