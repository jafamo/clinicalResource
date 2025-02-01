<?php

namespace App\Application\UseCase\Email;

use App\Domain\DTO\Email\EmailDTO;
use App\Domain\Service\EmailSenderInterface;

class SendEmailUseCase
{
    public function __construct(private EmailSenderInterface $emailSender) {}

    public function execute(EmailDTO $email): void
    {
        $this->emailSender->sendEmail($email);
    }

}