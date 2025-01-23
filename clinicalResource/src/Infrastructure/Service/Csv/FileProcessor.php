<?php

namespace App\Infrastructure\Service\Csv;

use PhpOffice\PhpSpreadsheet\IOFactory;

class FileProcessor
{
    public const START_ROW = 2;
    public function readExcelWithHeaders(string $filePath): array
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Extraer las cabeceras (primera fila)
        $headers = array_shift($rows);

        // Asociar cada fila con las cabeceras
        $data = [];
        foreach ($rows as $row) {
            $data[] = array_combine($headers, $row);
        }

        return $data;
    }
}