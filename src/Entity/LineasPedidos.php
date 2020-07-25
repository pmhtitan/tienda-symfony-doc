<?php

namespace App\Entity;

use App\Repository\LineasPedidosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineasPedidosRepository::class)
 */
class LineasPedidos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Pedido::class, inversedBy="lineasPedidos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pedido_id;

    /**
     * @ORM\OneToOne(targetEntity=Producto::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $producto_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $unidades;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPedidoId(): ?Pedido
    {
        return $this->pedido_id;
    }

    public function setPedidoId(?Pedido $pedido_id): self
    {
        $this->pedido_id = $pedido_id;

        return $this;
    }

    public function getProductoId(): ?Producto
    {
        return $this->producto_id;
    }

    public function setProductoId(Producto $producto_id): self
    {
        $this->producto_id = $producto_id;

        return $this;
    }

    public function getUnidades(): ?int
    {
        return $this->unidades;
    }

    public function setUnidades(int $unidades): self
    {
        $this->unidades = $unidades;

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
}
