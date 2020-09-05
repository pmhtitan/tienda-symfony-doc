<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true,  nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json",  nullable=true)
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string",  nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remember_token;

    /**
     * @ORM\OneToMany(targetEntity=Pedido::class, mappedBy="usuario")
     */
    private $pedidos;

    /**
     * @ORM\OneToMany(targetEntity=DatosFacturacion::class, mappedBy="usuario")
     */
    private $datosFacturacions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sessionUser;

    /**
     * @ORM\OneToOne(targetEntity=Carrito::class, mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $carrito;

    /* commented ---><
      @ORM\OneToMany(targetEntity=LineasPedidos::class, mappedBy="pedido")
     */
    // private $lineasPedidos;

    
    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
        $this->datosFacturacions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getRememberToken(): ?string
    {
        return $this->remember_token;
    }

    public function setRememberToken(?string $remember_token): self
    {
        $this->remember_token = $remember_token;

        return $this;
    }

    /**
     * @return Collection|Pedido[]
     */
    public function getPedidos(): Collection
    {
        return $this->pedidos;
    }

    public function addPedido(Pedido $pedido): self
    {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos[] = $pedido;
            $pedido->setUsuario($this);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): self
    {
        if ($this->pedidos->contains($pedido)) {
            $this->pedidos->removeElement($pedido);
            // set the owning side to null (unless already changed)
            if ($pedido->getUsuario() === $this) {
                $pedido->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DatosFacturacion[]
     */
    public function getDatosFacturacions(): Collection
    {
        return $this->datosFacturacions;
    }

    public function addDatosFacturacion(DatosFacturacion $datosFacturacion): self
    {
        if (!$this->datosFacturacions->contains($datosFacturacion)) {
            $this->datosFacturacions[] = $datosFacturacion;
            $datosFacturacion->setUsuario($this);
        }

        return $this;
    }

    public function removeDatosFacturacion(DatosFacturacion $datosFacturacion): self
    {
        if ($this->datosFacturacions->contains($datosFacturacion)) {
            $this->datosFacturacions->removeElement($datosFacturacion);
            // set the owning side to null (unless already changed)
            if ($datosFacturacion->getUsuario() === $this) {
                $datosFacturacion->setUsuario(null);
            }
        }

        return $this;
    }

    public function getSessionUser(): ?bool
    {
        return $this->sessionUser;
    }

    public function setSessionUser(bool $sessionUser): self
    {
        $this->sessionUser = $sessionUser;

        return $this;
    }

    public function getCarrito(): ?Carrito
    {
        return $this->carrito;
    }

    public function setCarrito(?Carrito $carrito): self
    {
        $this->carrito = $carrito;

        // set (or unset) the owning side of the relation if necessary
        $newUsuario = null === $carrito ? null : $this;
        if ($carrito->getUsuario() !== $newUsuario) {
            $carrito->setUsuario($newUsuario);
        }

        return $this;
    }

    public function statsCarrito($carrito, float $shippingPrice){
        $stats = array(
            'products' => 0,
            'items' => 0,
            'subtotal' => 0,
            'shippingPrice' => 0,
            'total' => 0,
        );

        if(isset($carrito)){
            $stats['products'] = count($carrito);

            foreach($carrito as $producto){
                $stats['subtotal'] += $producto['precio'] * $producto['unidades'];
                $stats['items'] += $producto['unidades'];
            } 
        }
        $stats['total'] = $stats['subtotal'] + $shippingPrice;
        $stats['shippingPrice'] = $shippingPrice;

        return $stats;
    }

   
}
