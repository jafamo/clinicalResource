<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'csv_records')]
class CsvRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $startTime;

    #[ORM\Column(type: 'string', length: 255)]
    private string $completionTime;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;
    #[ORM\Column(type: 'string', length: 255)]
    private string $lastModifiedTime;
    #[ORM\Column(type: 'string', length: 255)]
    private string $name2;
    #[ORM\Column(type: 'string', length: 255)]
    private string $surname;
    #[ORM\Column(type: 'string', length: 255)]
    private string $nameClinic;
    #[ORM\Column(type: 'string', length: 255)]
    private string $speciality;
    #[ORM\Column(type: 'string', length: 255)]
    private string $subSpeciality;
    #[ORM\Column(type: 'string', length: 255)]
    private string $web;
    #[ORM\Column(type: 'string', length: 255)]
    private string $phone;
    #[ORM\Column(type: 'string', length: 255)]
    private string $phone2;
    #[ORM\Column(type: 'string', length: 255)]
    private string $openingTimes;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email2;

    #[ORM\Column(type: 'string', length: 255)]
    private string $personContact;

    #[ORM\Column(type: 'string', length: 255)]
    private string $linkGoogle;



    public function __construct(
        int $id,
        \DateTime $startTime, //fecha dado de alya
        \DateTime $completionTime,
        string $email, // email del usuario que carga en la aplicación
        string $name,   //nombre del usuario que carga en la APP
        ?\DateTime $lastModifiedTime,
        ?string $name2, //nombre del doctor
        ?string $surname, //apellido doctor
        ?string $nameClinic, //medicalClinic
        ?string $speciality, //speciality parent
        ?string $subSpeciality, //speciality children
        ?string $web, //web doctor
        ?string $phone, //phone doctor
        ?string $phone2,
        ?string $openingTimes,
        ?string $email2, //email doctor
        ?string $personContact, //persona de contacto doctor
        ?string $linkGoogle //link de google maps
    )
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->completionTime = $completionTime;
        $this->email = $email;
        $this->name = $name;
        $this->lastModifiedTime = $lastModifiedTime;
        $this->name2 = $name2;
        $this->surname = $surname;
        $this->nameClinic = $nameClinic;
        $this->speciality = $speciality;
        $this->subSpeciality = $subSpeciality;
        $this->web = $web;
        $this->phone = $phone;
        $this->phone2 = $phone2;
        $this->openingTimes = $openingTimes;
        $this->email2 = $email2;
        $this->personContact = $personContact;
        $this->linkGoogle = $linkGoogle;
    }
}