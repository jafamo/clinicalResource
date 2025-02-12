<?php

namespace App\Application\UseCase;

use App\Application\DTO\CsvDataDTO;
use App\Application\UseCase\Doctor\CreateDoctorService;
use App\Application\UseCase\MedicalCenter\CreateMedicalCenterService;
use App\Application\UseCase\Speciality\CreateSpecialityService;
use App\Application\Validator\ValidationCsvInterface;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Psr\Log\LoggerInterface;

class ProcessFileUseCase
{

    private ValidationCsvInterface $validator;
    private CreateMedicalCenterService $medicalCenterService;
    private CreateSpecialityService $specialityService;
    private CreateDoctorService $doctorService;
    private LoggerInterface $logger;


    /**
     * @param ValidationCsvInterface $validator
     * @param CreateMedicalCenterService $medicalCenterService
     * @param CreateSpecialityService $specialityService
     * @param CreateDoctorService $doctorService
     */
    public function __construct(
        ValidationCsvInterface     $validator,
        CreateMedicalCenterService $medicalCenterService,
        CreateSpecialityService    $specialityService,
        CreateDoctorService        $doctorService,
        LoggerInterface           $logger
    )
    {
        $this->validator = $validator;
        $this->medicalCenterService = $medicalCenterService;
        $this->specialityService = $specialityService;
        $this->doctorService = $doctorService;
        $this->logger = $logger;
    }


    public function process(array $rows): array
    {
        $validRows = [];
        $errors = [];
        // Define un mapeo entre las cabeceras del archivo y las claves esperadas
        $headerMapping = [
            'ID' => 'id',
            'Start time' => 'startTime',
            'Completion time' => 'completionTime',
            'Email' => 'email',
            'Name' => 'name',
            'Last modified time' => 'lastModifiedTime',
            'Name2' => 'name2',
            'Surname' => 'surname',
            'Name of the Clinic/Medical Center' => 'nameClinic',
            'Specialty' => 'speciality',
            'Subspecialty' => 'subSpeciality',
            'WEB' => 'web',
            'Telefono' => 'phone',
            'Telefono2' => 'phone2',
            'OpeningTimes' => 'openingTimes',
            'Email2' => 'email2',
            'Person of contact' => 'personContact',
            'Link Google' => 'linkGoogle',
        ];

        foreach ($rows as $index => $row) {
            try {
                // Transformar las claves según el mapeo
                $mappedRow = [];
                foreach ($headerMapping as $header => $key) {
                    $mappedRow[$key] = $row[$header] ?? null;
                }

                $mappedRow['startTime'] = is_float($mappedRow['startTime'])
                    ? Date::excelToDateTimeObject($mappedRow['startTime'])
                    : null;
                $mappedRow['completionTime'] = is_float($mappedRow['completionTime'])
                    ? Date::excelToDateTimeObject($mappedRow['completionTime'])
                    : null;
                $mappedRow['lastModifiedTime'] = is_float($mappedRow['lastModifiedTime'])
                    ? Date::excelToDateTimeObject($mappedRow['lastModifiedTime'])
                    : null;


                // Crear el DTO usando el método estático createDTOFromData
                $dto = CsvDataDTO::createDTOFromData($mappedRow);

                $validationErrors = $this->validator->validate($dto);


                $phone = $this->processPhones($dto->phone, $dto->phone2);
                $email = $this->processEmail2($dto->email2);

                $medicalCenter = $this->medicalCenterService->createNewMedicalCenter($dto->nameClinic, $phone, $dto->web, $email);
                $subSpecialities = $this->specialityService->processSubspeciality($dto->subSpeciality);
                $speciality = $this->specialityService->createNewSpeciality($dto->speciality);
                $subSpeciality = null;
                if ($subSpecialities) {
                    // Procesar cada subespecialidad y asociarla a la especialidad principal
                    foreach ($subSpecialities as $subSpeciality) {
                        $subSpeciality = $this->specialityService->createNewSpeciality($subSpeciality, $speciality);
                    }
                }

                    $this->doctorService->createDoctor(
                        $dto->name2,
                        $dto->surname,
                        $email,
                        $phone,
                        $dto->openingTimes,
                        $dto->web,
                        $dto->linkGoogle,
                        '',
                        $medicalCenter,
                        $subSpeciality
                    );
                $this->logger->info('Indice:'.$index+1);
                $this->logger->info('Telefonos:'.$phone);
                if (count($validationErrors) > 0) {
                    // Agregar errores si hay validaciones fallidas
                    $errors[] = [
                        'row' => $index + 1,
                        'errors' => (string)$validationErrors,
                    ];

                    continue;
                }

                // Si todo está bien, agregar a las filas válidas
                $validRows[] = $dto;
            } catch (\Exception $e) {
                // Capturar errores durante la creación del DTO (p. ej., si falta un campo)
                $errors[] = [
                    'row' => $index + 1,
                    'errors' => $e->getMessage(),
                ];
                $this->logger->error($e->getTraceAsString());
            }
        }

        return ['valid' => $validRows, 'errors' => $errors];
    }

    public function processTwo(array $rows): array
    {
        $validRows = [];
        $errors = [];

        foreach ($rows as $index => $row) {
            $dto = CsvDataDTO::createDTOFromData($row);
            $validationErrors = $this->validator->validate($dto);

            if (count($validationErrors) > 0) {
                $errors[] = [
                    'row' => $index + 1,
                    'errors' => (string)$validationErrors,
                ];
                continue;
            }

            $validRows[] = $dto;
        }

        return ['valid' => $validRows, 'errors' => $errors];
    }


    private function processPhones(?string $phone1, ?string $phone2): ?string
    {
        // Limpiar espacios en blanco, guiones y normalizar los números
        $phone1 = preg_replace('/\s+|-/', '', trim($phone1 ?? ''));
        $phone2 = preg_replace('/\s+|-/', '', trim($phone2 ?? ''));

        // Si ambos están vacíos, devolver null
        if ($phone1 === '' && $phone2 === '') {
            return null;
        }

        // Juntar los teléfonos si ambos existen, sino devolver el que tenga valor
        return $phone1 && $phone2 ? "$phone1, $phone2" : ($phone1 ?: $phone2);
    }

    private function processEmail2(?string $email): ?string
    {
        return preg_replace('/\s+|-/', '', trim($email ?? ''));
    }
}