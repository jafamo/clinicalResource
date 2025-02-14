<?php

namespace App\Domain\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Infrastructure\Persistence\Doctrine\DoctorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctorRepository::class)]
#[ORM\Table(name: "doctor")]
#[ApiResource]
class Doctor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $openingTimes = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $linkWeb = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mapWeb = null;

    #[ORM\ManyToMany(targetEntity: MedicalCenter::class, inversedBy: 'medicos')]
    #[ORM\JoinTable(name: 'medical_with_doctor')] // Nombre de la tabla intermedia
    public Collection $centrosMedicos;

    #[ORM\ManyToMany(targetEntity: Speciality::class, inversedBy: 'medicos')]
    #[ORM\JoinTable(name: 'specialist_with_doctor')] // Nombre de la tabla intermedia
    public Collection $specialities;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $notes = null;

    public function __construct()
    {
        $this->centrosMedicos = new ArrayCollection();
        $this->specialities = new ArrayCollection();
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

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): static
    {
        $this->surname = $surname;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getOpeningTimes(): ?string
    {
        return $this->openingTimes;
    }

    public function setOpeningTimes(?string $openingTimes): static
    {
        $this->openingTimes = $openingTimes;

        return $this;
    }

    public function getLinkWeb(): ?string
    {
        return $this->linkWeb;
    }

    public function setLinkWeb(?string $linkWeb): static
    {
        $this->linkWeb = $linkWeb;

        return $this;
    }

    public function getMapWeb(): ?string
    {
        return $this->mapWeb;
    }

    public function setMapWeb(?string $mapWeb): static
    {
        $this->mapWeb = $mapWeb;

        return $this;
    }

    /**
     * @return Collection<int, MedicalCenter>
     */
    public function getCentrosMedicos(): Collection
    {
        return $this->centrosMedicos;
    }

    public function addCentroMedicos(MedicalCenter $centroMedico): self
    {
        if (!$this->centrosMedicos->contains($centroMedico)) {
            $this->centrosMedicos->add($centroMedico);
        }

        return $this;
    }

    public function removeCentroMedico(MedicalCenter $centroMedico): self
    {
        $this->centrosMedicos->removeElement($centroMedico);

        return $this;
    }


    /**
     * @return Collection<int, Speciality>
     */
    public function getSpecialist(): Collection
    {
        return $this->specialities;
    }

    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities->add($speciality);
        }

        return $this;
    }

    public function removeParameter(Speciality $speciality): self
    {
        $this->specialities->removeElement($speciality);

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? 'null';
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

}
