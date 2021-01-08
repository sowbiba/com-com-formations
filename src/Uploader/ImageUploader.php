<?php

namespace App\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    /**
     * @var string
     */
    private $uploadDirectory;
    /**
     * @var string
     */
    private $publicDirectory;
    /**
     * @var string
     */
    private $buildDirectory;

    public function __construct(string $uploadDirectory, string $buildDirectory, string $publicDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
        $this->publicDirectory = $publicDirectory;
        $this->buildDirectory = $buildDirectory;
    }

    public function upload(UploadedFile $file): string
    {
        $targetDirectory = rtrim($this->uploadDirectory, DIRECTORY_SEPARATOR)
            .DIRECTORY_SEPARATOR;
        $buildDirectory = rtrim($this->buildDirectory, DIRECTORY_SEPARATOR)
            .DIRECTORY_SEPARATOR;
        $publicDirectory = rtrim($this->publicDirectory, DIRECTORY_SEPARATOR)
            .DIRECTORY_SEPARATOR;

        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($targetDirectory, $fileName);
        copy($targetDirectory.$fileName, $buildDirectory.$fileName);

        return $publicDirectory.$fileName;
    }
}
