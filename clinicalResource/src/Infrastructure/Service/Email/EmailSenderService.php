<?php

namespace App\Infrastructure\Service\Email;

use App\Domain\DTO\Email\EmailDTO;
use App\Domain\Service\EmailSenderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailSenderService implements EmailSenderInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendEmail(EmailDTO $email): void
    {
        $message = (new Email())
            ->from($email->from)
            ->to($email->to)
            ->subject($email->subject)
            ->text($email->text)
            ->html($email->html);

        $this->mailer->send($message);
    }
}