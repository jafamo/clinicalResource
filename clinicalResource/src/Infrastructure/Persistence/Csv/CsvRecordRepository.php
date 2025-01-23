<?php

namespace App\Infrastructure\Persistence\Csv;

use App\Domain\Entity\CsvRecord;
use App\Domain\Repository\CsvRecordRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class CsvRecordRepository implements CsvRecordRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em) {}

    public function save(CsvRecord $record): void
    {
//        $this->em->persist($record);
//        $this->em->flush();
    }

}