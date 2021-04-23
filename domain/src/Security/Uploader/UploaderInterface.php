<?php

namespace TBoileau\CodeChallenge\Domain\Security\Uploader;

interface UploaderInterface
{
    public function getPath(): string;

    public function getOriginalName(): string;
}
