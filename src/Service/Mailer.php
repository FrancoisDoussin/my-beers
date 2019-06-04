<?php

namespace App\Service;

use Swift_Message;
use Twig\Environment;

class Mailer
{
    private $mailer;

    private $environment;

    public function __construct(\Swift_Mailer $mailer, Environment $environment)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    public function sendContactEmail(string $email, string $firstName, string $lastName): void
    {
        $message = (new Swift_Message('Contact My Beers'))
            ->setFrom($_ENV['MAILER_CONTACT_ADDRESS'])
            ->setTo($email)
            ->setBody(
                $this->environment->render(
                    'email/contact.html.twig',
                    [
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                    ]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}