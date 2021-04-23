<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Fixtures\Uploader;

use TBoileau\CodeChallenge\Domain\Security\Uploader\UploaderInterface;

class Uploader implements UploaderInterface
{
    private string $path;

    private string $originalName;

    public function __construct(string $path, string $originalName)
    {
        $this->path = $path;
        $this->originalName = $originalName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setPath(string $path): UploaderInterface
    {
        $this->path = $path;

        return $this;
    }

    public function setOriginalName(string $originalName): UploaderInterface
    {
        $this->originalName = $originalName;

        return $this;
    }
}
