<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Mail;

use Proximum\Vimeet365\Core\Application\Mail\AccountRegistrationMailerInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class AccountRegistrationMailer implements AccountRegistrationMailerInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Account $account): void
    {
        $email = (new TemplatedEmail())
            ->to(new Address($account->getEmail()))
            ->subject('Welcome on Vimeet365!')
            ->htmlTemplate('emails/account/registration.html.twig')
            ->context([
                'account' => $account,
            ]);

        $this->mailer->send($email);
    }
}
