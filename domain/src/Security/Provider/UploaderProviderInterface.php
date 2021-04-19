<?php

declare(strict_types=1);

namespace TBoileau\CodeChallenge\Domain\Security\Provider;

use TBoileau\CodeChallenge\Domain\Security\Uploader\Uploader;

interface UploaderProviderInterface
{

    /**
     * Return only file name with its extension (e. avatar.jpg)
     *
     * @param Uploader $uploader
     * @return string
     */
    public function upload(Uploader $uploader): string;
}
