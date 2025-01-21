<?php

namespace App\Domain\Repository;

use App\Domain\Entity\CsvRecord;

interface CsvRecordRepositoryInterface
{
    public function save(CsvRecord $record): void;

}