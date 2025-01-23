<?php

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CsvDataDTO
{

    public readonly int $id;

    #[Assert\NotBlank]
    public readonly ?\DateTimeInterface $startTime;
    public readonly ?\DateTime $completionTime;
    public readonly string $email;
    public readonly string $name;
    public readonly ?\DateTime $lastModifiedTime;
    public readonly ?string $name2;
    public readonly ?string $surname;
    public readonly ?string $nameClinic;
    public readonly ?string $speciality;
    public readonly ?string $subSpeciality;
    public readonly ?string $web;
    public readonly ?string $phone;
    public readonly ?string $phone2;
    public readonly ?string $openingTimes;
    public readonly ?string $email2;
    public readonly ?string $personContact;
    public readonly ?string $linkGoogle;

    /**
     * @param array $data
     * @return self
     */
    public static function createDTOFromData(array $data): self
    {
        $newDto = new self();
        $newDto->id = $data['id'];
        $newDto->startTime = $data['startTime']??null;
        $newDto->completionTime = $data['completionTime']??null;
        $newDto->email = $data['email'];
        $newDto->name = $data['name'];
        $newDto->lastModifiedTime = $data['lastModifiedTime']??null;
        $newDto->name2 = $data['name2'];
        $newDto->surname = $data['surname'];
        $newDto->nameClinic = $data['nameClinic'];
        $newDto->speciality = $data['speciality'];
        $newDto->subSpeciality = $data['subSpeciality'];
        $newDto->web = $data['web'];
        $newDto->phone = $data['phone'];
        $newDto->phone2 = $data['phone2'];
        $newDto->openingTimes = $data['openingTimes'];
        $newDto->email2 = $data['email2'];
        $newDto->personContact = $data['personContact'];
        $newDto->linkGoogle = $data['linkGoogle'];

        return $newDto;
    }
}
