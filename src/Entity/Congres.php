<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CongresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**

 * @ApiResource(
 *     normalizationContext={"groups"={"congres:read"}},
 *     denormalizationContext={"groups"={"congres:write"}},
 *     itemOperations={
 *          "get",
 *          "put",
 *          "delete"  ,
 *          
 * },
 * 
 *     collectionOperations={"get",
 *              "post"
 * },
 *         
 * ),
 * @ORM\Entity(repositoryClass=CongresRepository::class)
 */
class Congres
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("congres:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"congres:read", "congres:write"})
     * @Assert\Length(min=3, max=50) 
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"congres:read", "congres:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"congres:read", "congres:write"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Salle::class, inversedBy="congres")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"congres:read", "congres:write"})
     */
    private $salle;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="congres")
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }


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

    public function getSalle(): ?salle
    {
        return $this->salle;
    }

    public function setSalle(?salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setCongres($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getCongres() === $this) {
                $booking->setCongres(null);
            }
        }

        return $this;
    }


}
