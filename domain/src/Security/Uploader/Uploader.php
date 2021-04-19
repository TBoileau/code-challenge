<?php

namespace TBoileau\CodeChallenge\Domain\Security\Uploader;

class Uploader
{

    private string $path;

    private string $originalName;

    public function __construct(string $path, string $originalName)
    {
        $this->path = $path;
        $this->originalName = $originalName;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }
}
