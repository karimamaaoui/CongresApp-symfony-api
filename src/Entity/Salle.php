<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SalleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ApiResource(
 *     normalizationContext={"groups"={"salle:read"}},
 *     denormalizationContext={"groups"={"salle:write"}},
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
* @ORM\Entity(repositoryClass=SalleRepository::class)
 */
class Salle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("salle:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"salle:read", "salle:write"})
     * @Assert\Length(min=3, max=50) 
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Congres::class, mappedBy="salle")
     */
    private $congres;

    public function __construct()
    {
        $this->congres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Congres[]
     */
    public function getCongres(): Collection
    {
        return $this->congres;
    }

    public function addCongre(Congres $congre): self
    {
        if (!$this->congres->contains($congre)) {
            $this->congres[] = $congre;
            $congre->setSalle($this);
        }

        return $this;
    }

    public function removeCongre(Congres $congre): self
    {
        if ($this->congres->removeElement($congre)) {
            // set the owning side to null (unless already changed)
            if ($congre->getSalle() === $this) {
                $congre->setSalle(null);
            }
        }

        return $this;
    }
}
