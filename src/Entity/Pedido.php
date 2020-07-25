<?php

namespace App\Entity;

use App\Repository\PedidoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PedidoRepository::class)
 */
class Pedido
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pedido")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario_id;

    /**
     * @ORM\Column(type="float")
     */
    private $coste;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $estado;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=LineasPedidos::class, mappedBy="pedido_id")
     */
    private $lineasPedidos;

    public function __construct()
    {
        $this->lineasPedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuarioId(): ?User
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(?User $usuario_id): self
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    public function getCoste(): ?float
    {
        return $this->coste;
    }

    public function setCoste(float $coste): self
    {
        $this->coste = $coste;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): self
    {
        $this->estado = $estado;

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
     * @return Collection|LineasPedidos[]
     */
    public function getLineasPedidos(): Collection
    {
        return $this->lineasPedidos;
    }

    public function addLineasPedido(LineasPedidos $lineasPedido): self
    {
        if (!$this->lineasPedidos->contains($lineasPedido)) {
            $this->lineasPedidos[] = $lineasPedido;
            $lineasPedido->setPedidoId($this);
        }

        return $this;
    }

    public function removeLineasPedido(LineasPedidos $lineasPedido): self
    {
        if ($this->lineasPedidos->contains($lineasPedido)) {
            $this->lineasPedidos->removeElement($lineasPedido);
            // set the owning side to null (unless already changed)
            if ($lineasPedido->getPedidoId() === $this) {
                $lineasPedido->setPedidoId(null);
            }
        }

        return $this;
    }
}
