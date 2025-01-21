<?php

namespace App\Application\Validator;

use App\Application\DTO\CsvDataDTO;

interface ValidationCsvInterface
{
    public function validate(CsvDataDTO $data): array;

}