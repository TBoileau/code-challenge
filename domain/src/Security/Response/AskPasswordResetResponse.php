<?php

namespace TBoileau\CodeChallenge\Domain\Security\Response;

/**
 * Class AskPasswordResetResponse
 * @package TBoileau\CodeChallenge\Domain\Security\Response
 */
class AskPasswordResetResponse
{
    /**
     * @var bool
     */
    private bool $passwordResetLinkSent;

    /**
     * @var string
     */
    private string $link;

    /**
     * AskPasswordResetResponse constructor.
     * @param bool $passwordResetLinkSent
     * @param string $link
     */
    public function __construct(bool $passwordResetLinkSent, string $link)
    {
        $this->passwordResetLinkSent = $passwordResetLinkSent;
        $this->link = $link;
    }

    /**
     * @return bool
     */
    public function isPasswordResetLinkSent(): bool
    {
        return $this->passwordResetLinkSent;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
}
