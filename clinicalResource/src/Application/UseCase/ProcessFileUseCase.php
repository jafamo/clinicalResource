<?php

namespace App\Application\UseCase;

use App\Application\DTO\CsvDataDTO;
use App\Application\Validator\ValidationCsvInterface;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProcessFileUseCase
{

    private ValidationCsvInterface $validator;

    public function __construct(ValidationCsvInterface $validator)
    {
        $this->validator = $validator;
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

                // Validar el DTO
                $validationErrors = $this->validator->validate($dto);

                if (count($validationErrors) > 0) {
                    // Agregar errores si hay validaciones fallidas
                    $errors[] = [
                        'row' => $index + 1,
                        'errors' => (string) $validationErrors,

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
                    'errors' => (string) $validationErrors,
                ];
                continue;
            }

            $validRows[] = $dto;
        }

        return ['valid' => $validRows, 'errors' => $errors];
    }

}