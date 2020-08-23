<?php

namespace App\Entity;

use App\Repository\CarritoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarritoRepository::class)
 */
class Carrito
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="carrito", cascade={"persist", "remove"})
     */
    private $usuario;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $subtotal;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=LineasCarrito::class, mappedBy="carrito")
     */
    private $lineasCarritos;

    public function __construct()
    {
        $this->lineasCarritos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(?float $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|LineasCarrito[]
     */
    public function getLineasCarritos(): Collection
    {
        return $this->lineasCarritos;
    }

    public function addLineasCarrito(LineasCarrito $lineasCarrito): self
    {
        if (!$this->lineasCarritos->contains($lineasCarrito)) {
            $this->lineasCarritos[] = $lineasCarrito;
            $lineasCarrito->setCarrito($this);
        }

        return $this;
    }

    public function removeLineasCarrito(LineasCarrito $lineasCarrito): self
    {
        if ($this->lineasCarritos->contains($lineasCarrito)) {
            $this->lineasCarritos->removeElement($lineasCarrito);
            // set the owning side to null (unless already changed)
            if ($lineasCarrito->getCarrito() === $this) {
                $lineasCarrito->setCarrito(null);
            }
        }

        return $this;
    }
}
