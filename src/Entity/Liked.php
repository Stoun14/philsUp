<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LikedRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LikedRepository::class)]
#[ApiResource(collectionOperations:["get", "post"], itemOperations:["get", "delete"], normalizationContext:["groups"=>["like:read"]], denormalizationContext:["groups"=>["like:write"]])]
class Liked
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'likeds')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["like:read", "like:write"])]
    private $user;

    #[ORM\ManyToOne(targetEntity: Message::class, inversedBy: 'likeds')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["like:read", "like:write"])]
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }
}
