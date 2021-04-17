<?php

declare(strict_types=1);

namespace TBoileau\CodeChallenge\Domain\Security\Provider;

interface UploaderProviderInterface
{

    /**
     * Return only file name with its extension (e. avatar.jpg)
     *
     * @param string $path
     * @return string
     */
    public function upload(string $path): string;
}
