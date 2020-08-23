<?php

namespace App\Entity;

use App\Repository\LineasCarritoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineasCarritoRepository::class)
 */
class LineasCarrito
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Carrito::class, inversedBy="lineasCarritos")
     */
    private $carrito;

    /**
     * @ORM\ManyToOne(targetEntity=Producto::class, inversedBy="lineasCarritos")
     */
    private $producto;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\Column(type="integer")
     */
    private $unidades;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarrito(): ?Carrito
    {
        return $this->carrito;
    }

    public function setCarrito(?Carrito $carrito): self
    {
        $this->carrito = $carrito;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

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
}
