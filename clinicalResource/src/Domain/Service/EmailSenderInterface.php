<?php

namespace App\Domain\Service;

use App\Domain\DTO\Email\EmailDTO;

interface EmailSenderInterface
{
    public function sendEmail(EmailDTO $email): void;
}