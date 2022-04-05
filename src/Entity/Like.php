<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LikeRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LikeRepository::class)]
#[ORM\Table(name: '`like`')]
#[ApiResource(collectionOperations:["get", "post"], itemOperations:["get", "delete"], normalizationContext:["groups"=>["read"]], denormalizationContext:["groups"=>["write"]])]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read", "write"])]
    private $user;

    #[ORM\ManyToOne(targetEntity: Message::class, inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read", "write"])]
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
