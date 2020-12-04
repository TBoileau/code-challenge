<?php

namespace TBoileau\CodeChallenge\Domain\Security\Provider;

interface MailProviderInterface
{
    public function send(string $from, string $to, string $subject, string $message): bool;
}
