<?php

namespace App\Service;

use App\Helper\StringHelper;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\UrlHelper;

class FileUploader
{
    private $uploadPath;
    private $slugger;
    private $urlHelper;
    private $relativeUploadsDir;
    private $mimeType;
    private $fileExt;
    private $fileSize;

    public function __construct($publicPath, $uploadPath, SluggerInterface $slugger, UrlHelper $urlHelper)
    {
        $this->uploadPath = $uploadPath;
        $this->slugger = $slugger;
        $this->urlHelper = $urlHelper;

        // get uploads directory relative to public path //  "/uploads/"
        $this->relativeUploadsDir = str_replace($publicPath, '', $this->uploadPath).'/';
    }

    /**
     * @throws \JsonException
     */
    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);

        $fileName = $safeFilename.".".$file->guessExtension();

        $directory = StringHelper::randomString(8);
        $this->mimeType = $file->getClientMimeType();
        $this->fileExt = $file->guessExtension();
        $this->fileSize = $file->getSize();

        try {
            $file->move($this->getuploadPath()."/".$directory, $fileName);
        } catch (FileException $e) {

        }

        return $directory."/".$fileName;
    }

    public function getuploadPath()
    {
        return $this->uploadPath;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function getFileExt()
    {
        return $this->fileExt;
    }

    public function getFileSize()
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($this->fileSize, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    public function getUrl(?string $fileName, bool $absolute = true)
    {
        if (empty($fileName)) return null;

        if ($absolute) {
            return $this->urlHelper->getAbsoluteUrl($this->relativeUploadsDir.$fileName);
        }

        return $this->urlHelper->getRelativePath($this->relativeUploadsDir.$fileName);
    }
}