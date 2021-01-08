<?php

namespace App\Controller\Admin;

use App\Entity\Encart;
use App\Uploader\ImageUploader;
use App\Manager\EncartsManager;
use App\Form\EncartType;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class EncartsController extends AbstractController
{
    /**
     * @var EncartsManager
     */
    private $encartsManager;
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ImageUploader
     */
    private $imageUploader;

    public function __construct(
        EncartsManager $encartsManager,
        ImageUploader $imageUploader,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        $this->encartsManager = $encartsManager;
        $this->translator = $translator;
        $this->logger = $logger;
        $this->imageUploader = $imageUploader;
    }

    /**
     * @Route("/encarts", name="app_admin_encarts")
     */
    public function index(Request $request)
    {
        $page = $request->query->get('page', 1);
        $sortField = $request->query->get('sort', 'id');
        $sortDirection = $request->query->get('direction', 'DESC');

        $pager = $this->encartsManager->search([], [$sortField => $sortDirection], $page);

        return $this->render('admin/encarts/index.html.twig', [
            'pager' => $pager,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * @Route("/encarts/new", name="app_admin_encarts_create")
     */
    public function create(Request $request)
    {
        $form = $this->createForm(EncartType::class, null, ['attr' => ['novalidate' => 'novalidate']]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Encart $encart */
            $encart = $form->getData();

            try {
                if ($form->get('image')->isSubmitted() && !empty($form->get('image')->getData())) {
                    $fileName = $this->imageUploader->upload($form->get('image')->getData());
                    $encart->setImage($fileName);
                }

                $this->encartsManager->save($encart);

                $this->addFlash('success', $this->translator->trans('Encart successfully saved'));
            } catch (\Exception $exception) {
                $this->logger->error('Cannot save formation', [
                    'exception_message' => $exception->getMessage(),
                    'exception_file' => $exception->getFile(),
                    'exception_line' => $exception->getLine(),
                ]);

                $this->addFlash('error', $this->translator->trans('An error occurred when saving'));
            }

            return $this->redirectToRoute('app_admin_encarts');
        }

        return $this->render('admin/encarts/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/encarts/{id}/edit", name="app_admin_encarts_edit")
     * @ParamConverter("encart", class="App:Encart")
     */
    public function edit(Request $request, Encart $encart)
    {
        $form = $this->createForm(EncartType::class, $encart);
        $oldImage = $encart->getImage();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Encart $encart */
            $encart = $form->getData();

            try {
                if ($form->get('image')->isSubmitted() && !empty($form->get('image')->getData())) {
                    $fileName = $this->imageUploader->upload($form->get('image')->getData());
                    $encart->setImage($fileName);
                } else {
                    $encart->setImage($oldImage);
                }

                $this->encartsManager->save($encart);

                $this->addFlash('success', $this->translator->trans('Encart #%id% successfully updated', ['%id%' => $encart->getId()]));
            } catch (\Exception $exception) {
                $this->logger->error(
                    'An error occurred during the encart save. Check if attributes are unique',
                    [
                        'exception_type' => get_class($exception),
                        'exception_message' => $exception->getMessage(),
                        'exception_file' => $exception->getFile(),
                        'exception_line' => $exception->getLine(),
                    ]
                );

                $this->addFlash('error', 'Cannot save encart');
            }

            return $this->redirectToRoute('app_admin_encarts');
        }

        return $this->render('admin/encarts/edit.html.twig', [
            'form' => $form->createView(),
            'encart' => $encart,
        ]);
    }

    /**
     * @Route("/encarts/{id}", name="app_admin_encarts_delete", methods={"DELETE"}, condition="request.isXmlHttpRequest()")
     * @ParamConverter("encart", class="App:Encart")
     */
    public function delete(Request $request, Encart $encart)
    {
        $encartId = $encart->getId();
        try {
            $this->encartsManager->delete($encart);

            $this->addFlash('success', sprintf('Encart #%d successfully deleted', $encartId));
        } catch (\Exception $exception) {
            $this->logger->error('Cannot delete encart', [
                'exception_message' => $exception->getMessage(),
                'exception_file' => $exception->getFile(),
                'exception_line' => $exception->getLine(),
            ]);

            $this->addFlash('error', 'Cannot delete encart');
        }

        return new JsonResponse(sprintf('Delete %d OK', $encartId));
    }
}
