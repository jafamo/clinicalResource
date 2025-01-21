<?php

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Infrastructure\Persistence\Doctrine\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialityRepository::class)]
#[ORM\Table(name: "specialization")]
#[ApiResource]
class Speciality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: "children")]
    #[ORM\JoinColumn(onDelete: "CASCADE")] // Si eliminas una categoría, elimina sus subcategorías
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: "parent", targetEntity: self::class)]
    public Collection $children;

    #[ORM\ManyToMany(targetEntity: Doctor::class, mappedBy: 'specialities')]
    public Collection $medicos;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->medicos = new ArrayCollection();
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Doctor>
     */
    public function getMedicos(): Collection
    {
        return $this->medicos;
    }
}