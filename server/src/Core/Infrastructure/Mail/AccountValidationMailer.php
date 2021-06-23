<?php

declare(strict_types=1);

namespace Proximum\Vimeet365\Core\Infrastructure\Mail;

use Proximum\Vimeet365\Core\Application\Mail\AccountValidationMailerInterface;
use Proximum\Vimeet365\Core\Domain\Entity\Account;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class AccountValidationMailer implements AccountValidationMailerInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    private function buildUrl(string $origin, string $token, Account $account): string
    {
        return $origin . '/en/onboarding/account-validation?userId=' . $account->getId() . '&token=' . $token;
    }

    public function send(Account $account, string $token, string $origin): void
    {
        $email = (new TemplatedEmail())
            ->to(new Address($account->getEmail()))
            ->subject('Welcome on Vimeet365!')
            ->htmlTemplate('emails/account/validation.html.twig')
            ->context([
                'accountValidationUrl' => $this->buildUrl($origin, $token, $account),
            ]);

        $this->mailer->send($email);
    }
}
