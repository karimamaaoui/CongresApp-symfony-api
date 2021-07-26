<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CongressesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"congresses:read"}},
 *     denormalizationContext={"groups"={"congresses:write"},
 * },
 * 
 * itemOperations={
 *          "get",
 *          "put",
 *          "delete"  ,
 *          
 * },
 *     collectionOperations={"get","post"},
 *     
 * )
 * @ORM\Entity(repositoryClass=CongressesRepository::class)
 */
class Congresses
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("congresses:read")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"congresses:read", "congresses:write"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * 
     * @Groups({"congresses:read", "congresses:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups({"congresses:read", "congresses:write"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="congress")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({"congresses:read", "congresses:write"})
     */
    private $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
