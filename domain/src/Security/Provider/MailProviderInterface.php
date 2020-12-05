<?php

namespace TBoileau\CodeChallenge\Domain\Security\Provider;

interface MailProviderInterface
{
    public function sendPasswordResetLink(string $email, string $pseudo, string $link): void;
}
