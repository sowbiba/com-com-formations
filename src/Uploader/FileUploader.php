<?php

namespace App\Uploader;

use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    const AUTHORIZED_EXTENSIONS = [
        'pdf',
        'doc',
        'docx',
        'xls',
        'xlsx',
    ];

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

    /**
     * @var array
     */
    private $authorizedExtensions;

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

        $authorizedExtensions = $this->authorizedExtensions ?? self::AUTHORIZED_EXTENSIONS;

        if (!in_array($file->guessExtension(), $authorizedExtensions)) {
            throw new ExtensionFileException(sprintf('Expected file types : [%s], %s type given', implode(', ', $authorizedExtensions), $file->guessExtension()));
        }

        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($targetDirectory, $fileName);
        copy($targetDirectory.$fileName, $buildDirectory.$fileName);

        return $publicDirectory.$fileName;
    }

    public function setAuthorizedExtensions(array $authorizedExtensions): self
    {
        $this->authorizedExtensions = $authorizedExtensions;

        return $this;
    }
}
