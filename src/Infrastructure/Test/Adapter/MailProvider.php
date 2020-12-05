<?php

namespace App\Infrastructure\Test\Adapter;

class MailProvider implements \TBoileau\CodeChallenge\Domain\Security\Provider\MailProviderInterface
{

    public function sendPasswordResetLink(string $email, string $pseudo, string $link): void
    {
    }
}
