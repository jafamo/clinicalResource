<?php

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Infrastructure\Persistence\Doctrine\MedicalCenterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicalCenterRepository::class)]
#[ORM\Table(name: "medical_center")]
#[ApiResource]
class MedicalCenter                                                                                                                                                 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneGeneric = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mapLink = null;

    #[ORM\ManyToMany(targetEntity: Doctor::class, mappedBy: 'centrosMedicos')]
    public ?Collection $medicos;

    public function __construct()
    {
        $this->medicos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneGeneric(): ?string
    {
        return $this->phoneGeneric;
    }

    public function setPhoneGeneric(?string $phoneGeneric): static
    {
        $this->phoneGeneric = $phoneGeneric;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMapLink(): ?string
    {
        return $this->mapLink;
    }

    public function setMapLink(?string $mapLink): static
    {
        $this->mapLink = $mapLink;

        return $this;
    }

    /**
     * @return Collection<int, Doctor>
     */
    public function getMedicos(): Collection
    {
        return $this->medicos;
    }


    public function __toString(): string
    {
        return $this->name ?? 'null';
    }

}
