<?php

namespace App\Controller\Admin;

use App\Uploader\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImagesUploadController extends AbstractController
{
    /**
     * @var ImageUploader
     */
    private $imageUploader;

    public function __construct(
        ImageUploader $imageUploader
    ) {
        $this->imageUploader = $imageUploader;
    }

    /**
     * @Route(
     *     "/images/upload",
     *     name="app_admin_images_upload",
     *     methods={"POST"},
     *     options = {"expose"=true},
     * )
     */
    public function uploadImage(Request $request)
    {
        if (
            !$request->files->has('image') ||
            !($request->files->get('image') instanceof UploadedFile)
        ) {
            return new JsonResponse('Unexpected content', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $fileName = $this->imageUploader->upload($request->files->get('image'));

        return new JsonResponse(['location' => $fileName]);
    }
}
