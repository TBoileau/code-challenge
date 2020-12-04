<?php


namespace App\UserInterface\ViewModel\Security;


class AskPasswordResetViewModel
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
     * AskPasswordResetViewModel constructor.
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
