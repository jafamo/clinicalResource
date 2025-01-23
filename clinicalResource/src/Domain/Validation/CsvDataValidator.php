<?php

namespace App\Domain\Validation;

use App\Application\DTO\CsvDataDTO;
use App\Application\Validator\ValidationCsvInterface;

class CsvDataValidator implements ValidationCsvInterface
{

    public function validate(CsvDataDTO $data): array
    {
        $errors = [];

        if (empty($data->email) || !filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El email no es válido.';
        }

        if (empty($data->name)) {
            $errors[] = 'El nombre es obligatorio.';
        }

        if (!empty($data->web) && !filter_var($data->web, FILTER_VALIDATE_URL)) {
            $errors[] = 'La URL del sitio web no es válida.';
        }

        return $errors;
    }
}