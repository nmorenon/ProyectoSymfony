<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagen = null;

    #[ORM\Column(nullable: true)]
    private ?int $codigo = null;

    #[ORM\ManyToMany(targetEntity: Debilidad::class, inversedBy: 'pokemon')]
    private Collection $debilidad;

    public function __construct()
    {
        $this->debilidad = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    public function setCodigo(?int $codigo): static
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * @return Collection<int, Debilidad>
     */
    public function getDebilidad(): Collection
    {
        return $this->debilidad;
    }

    public function addDebilidad(Debilidad $debilidad): static
    {
        if (!$this->debilidad->contains($debilidad)) {
            $this->debilidad->add($debilidad);
        }

        return $this;
    }

    public function removeDebilidad(Debilidad $debilidad): static
    {
        $this->debilidad->removeElement($debilidad);

        return $this;
    }
}
