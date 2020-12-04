<?php


namespace TBoileau\CodeChallenge\Domain\Security\Provider;


use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;

interface PasswordResetLinkGeneratorInterface
{
    public function generateLink(Participant $participant): string;
}
