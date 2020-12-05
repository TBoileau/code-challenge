<?php

namespace App\Infrastructure\Adapter\Provider;

use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Address;
use TBoileau\CodeChallenge\Domain\Security\Provider\MailProviderInterface;

/**
 * Class MailProvider
 * @package App\Infrastructure\Adapter\Provider
 */
class MailProvider implements MailProviderInterface
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;

    /**
     * @var string
     */
    private string $fromEmail;

    /**
     * @var string
     */
    private string $displayName;

    /**
     * MailProvider constructor.
     * @param MessageBusInterface $bus
     * @param string $fromEmail
     * @param string $displayName
     */
    public function __construct(MessageBusInterface $bus, string $fromEmail, string $displayName)
    {
        $this->bus = $bus;
        $this->fromEmail = $fromEmail;
        $this->displayName = $displayName;
    }

    /**
     * @param string $email
     * @param string $pseudo
     * @param string $link
     */
    public function sendPasswordResetLink(string $email, string $pseudo, string $link): void
    {
        $email = (new NotificationEmail())
            ->from(
                new Address($this->fromEmail, $this->displayName)
            )
            ->to(
                new Address($email, $pseudo)
            )
            ->subject("[ Code Challenge ] Réinitialisation de mot de passe")
            ->htmlTemplate('emails/password_reset_request.html.twig')
            ->context([
                'pseudo' => $pseudo,
                'link' => $link,
            ])
        ;

        $message = new SendEmailMessage($email);

        $this->bus->dispatch($message);
    }
}
