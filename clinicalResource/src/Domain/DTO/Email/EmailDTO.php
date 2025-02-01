<?php

namespace App\Domain\DTO\Email;

class EmailDTO
{
    public function __construct(
        public string $from,
        public string $to,
        public string $subject,
        public string $text,
        public string $html
    ) {}
}