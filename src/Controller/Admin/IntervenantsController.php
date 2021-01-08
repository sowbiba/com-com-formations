<?php

namespace App\Controller\Admin;

use App\Entity\Intervenant;
use App\Uploader\ImageUploader;
use App\Manager\IntervenantsManager;
use App\Form\IntervenantType;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class IntervenantsController extends AbstractController
{
    /**
     * @var IntervenantsManager
     */
    private $intervenantsManager;
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
        IntervenantsManager $intervenantsManager,
        ImageUploader $imageUploader,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        $this->intervenantsManager = $intervenantsManager;
        $this->translator = $translator;
        $this->logger = $logger;
        $this->imageUploader = $imageUploader;
    }

    /**
     * @Route("/intervenants", name="app_admin_intervenants")
     */
    public function index(Request $request)
    {
        $page = $request->query->get('page', 1);
        $sortField = $request->query->get('sort', 'id');
        $sortDirection = $request->query->get('direction', 'DESC');

        $pager = $this->intervenantsManager->search([], [$sortField => $sortDirection], $page);

        return $this->render('admin/intervenants/index.html.twig', [
            'pager' => $pager,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * @Route("/intervenants/new", name="app_admin_intervenants_create")
     */
    public function create(Request $request)
    {
        $form = $this->createForm(IntervenantType::class, null, ['attr' => ['novalidate' => 'novalidate']]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Intervenant $intervenant */
            $intervenant = $form->getData();

            try {
                if ($form->get('image')->isSubmitted() && !empty($form->get('image')->getData())) {
                    $fileName = $this->imageUploader->upload($form->get('image')->getData());
                    $intervenant->setImage($fileName);
                }

                $this->intervenantsManager->save($intervenant);

                $this->addFlash('success', $this->translator->trans('Intervenant successfully saved'));
            } catch (\Exception $exception) {
                $this->logger->error('Cannot save formation', [
                    'exception_message' => $exception->getMessage(),
                    'exception_file' => $exception->getFile(),
                    'exception_line' => $exception->getLine(),
                ]);

                $this->addFlash('error', $this->translator->trans('An error occurred when saving'));
            }

            return $this->redirectToRoute('app_admin_intervenants');
        }

        return $this->render('admin/intervenants/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/intervenants/{id}/edit", name="app_admin_intervenants_edit")
     * @ParamConverter("intervenant", class="App:Intervenant")
     */
    public function edit(Request $request, Intervenant $intervenant)
    {
        $form = $this->createForm(IntervenantType::class, $intervenant);
        $oldImage = $intervenant->getImage();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Intervenant $intervenant */
            $intervenant = $form->getData();

            try {
                if ($form->get('image')->isSubmitted() && !empty($form->get('image')->getData())) {
                    $fileName = $this->imageUploader->upload($form->get('image')->getData());
                    $intervenant->setImage($fileName);
                } else {
                    $intervenant->setImage($oldImage);
                }

                $this->intervenantsManager->save($intervenant);

                $this->addFlash('success', $this->translator->trans('Intervenant #%id% successfully updated', ['%id%' => $intervenant->getId()]));
            } catch (\Exception $exception) {
                $this->logger->error(
                    'An error occurred during the intervenant save. Check if attributes are unique',
                    [
                        'exception_type' => get_class($exception),
                        'exception_message' => $exception->getMessage(),
                        'exception_file' => $exception->getFile(),
                        'exception_line' => $exception->getLine(),
                    ]
                );

                $this->addFlash('error', 'Cannot save intervenant');
            }

            return $this->redirectToRoute('app_admin_intervenants');
        }

        return $this->render('admin/intervenants/edit.html.twig', [
            'form' => $form->createView(),
            'intervenant' => $intervenant,
        ]);
    }

    /**
     * @Route("/intervenants/{id}", name="app_admin_intervenants_delete", methods={"DELETE"}, condition="request.isXmlHttpRequest()")
     * @ParamConverter("intervenant", class="App:Intervenant")
     */
    public function delete(Request $request, Intervenant $intervenant)
    {
        $intervenantId = $intervenant->getId();
        try {
            $this->intervenantsManager->delete($intervenant);

            $this->addFlash('success', sprintf('Intervenant #%d successfully deleted', $intervenantId));
        } catch (\Exception $exception) {
            $this->logger->error('Cannot delete intervenant', [
                'exception_message' => $exception->getMessage(),
                'exception_file' => $exception->getFile(),
                'exception_line' => $exception->getLine(),
            ]);

            $this->addFlash('error', 'Cannot delete intervenant');
        }

        return new JsonResponse(sprintf('Delete %d OK', $intervenantId));
    }
}
