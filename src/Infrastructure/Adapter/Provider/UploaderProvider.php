<?php

namespace App\Infrastructure\Adapter\Provider;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use TBoileau\CodeChallenge\Domain\Security\Provider\UploaderProviderInterface;
use TBoileau\CodeChallenge\Domain\Security\Uploader\Uploader;

class UploaderProvider implements UploaderProviderInterface
{

    private SluggerInterface $slugger;

    private string $directoryAvatarPath;

    public function __construct(SluggerInterface $slugger, string $directoryAvatarPath)
    {
        $this->slugger = $slugger;
        $this->directoryAvatarPath = $directoryAvatarPath;
    }

    public function upload(Uploader $uploader): string
    {
        $avatarFile = new UploadedFile($uploader->getPath(), $uploader->getOriginalName());

        $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

        try {
            $avatarFile->move(
                $this->directoryAvatarPath,
                $newFilename
            );
        } catch (FileException $exception) {
            die($exception->getMessage());
        }

        return $newFilename;
    }
}
