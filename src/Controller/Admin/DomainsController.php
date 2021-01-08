<?php

namespace App\Controller\Admin;

use App\Entity\Domain;
use App\Uploader\ImageUploader;
use App\Manager\DomainsManager;
use App\Form\DomainType;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DomainsController extends AbstractController
{
    /**
     * @var DomainsManager
     */
    private $domainsManager;
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
        DomainsManager $domainsManager,
        ImageUploader $imageUploader,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        $this->domainsManager = $domainsManager;
        $this->translator = $translator;
        $this->logger = $logger;
        $this->imageUploader = $imageUploader;
    }

    /**
     * @Route("/domains", name="app_admin_domains")
     */
    public function index(Request $request)
    {
        $page = $request->query->get('page', 1);
        $sortField = $request->query->get('sort', 'id');
        $sortDirection = $request->query->get('direction', 'DESC');

        $pager = $this->domainsManager->search([], [$sortField => $sortDirection], $page);

        return $this->render('admin/domains/index.html.twig', [
            'pager' => $pager,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * @Route("/domains/new", name="app_admin_domains_create")
     */
    public function create(Request $request)
    {
        $form = $this->createForm(DomainType::class, null, ['attr' => ['novalidate' => 'novalidate']]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Domain $domain */
            $domain = $form->getData();

            try {
                $this->domainsManager->save($domain);

                $this->addFlash('success', $this->translator->trans('Domain successfully saved'));
            } catch (\Exception $exception) {
                $this->logger->error('Cannot save formation', [
                    'exception_message' => $exception->getMessage(),
                    'exception_file' => $exception->getFile(),
                    'exception_line' => $exception->getLine(),
                ]);

                $this->addFlash('error', $this->translator->trans('An error occurred when saving'));
            }

            return $this->redirectToRoute('app_admin_domains');
        }

        return $this->render('admin/domains/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/domains/{id}/edit", name="app_admin_domains_edit")
     * @ParamConverter("domain", class="App:Domain")
     */
    public function edit(Request $request, Domain $domain)
    {
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Domain $domain */
            $domain = $form->getData();

            try {
                $this->domainsManager->save($domain);

                $this->addFlash('success', $this->translator->trans('Domain #%id% successfully updated', ['%id%' => $domain->getId()]));
            } catch (\Exception $exception) {
                $this->logger->error(
                    'An error occurred during the domain save',
                    [
                        'exception_type' => get_class($exception),
                        'exception_message' => $exception->getMessage(),
                        'exception_file' => $exception->getFile(),
                        'exception_line' => $exception->getLine(),
                    ]
                );

                $this->addFlash('error', 'Cannot save domain');
            }

            return $this->redirectToRoute('app_admin_domains');
        }

        return $this->render('admin/domains/edit.html.twig', [
            'form' => $form->createView(),
            'domain' => $domain,
        ]);
    }

    /**
     * @Route("/domains/{id}", name="app_admin_domains_delete", methods={"DELETE"}, condition="request.isXmlHttpRequest()")
     * @ParamConverter("domain", class="App:Domain")
     */
    public function delete(Request $request, Domain $domain)
    {
        $domainId = $domain->getId();
        try {
            $this->domainsManager->delete($domain);

            $this->addFlash('success', sprintf('Domain #%d successfully deleted', $domainId));
        } catch (\Exception $exception) {
            $this->logger->error('Cannot delete domain', [
                'exception_message' => $exception->getMessage(),
                'exception_file' => $exception->getFile(),
                'exception_line' => $exception->getLine(),
            ]);

            $this->addFlash('error', 'Cannot delete domain');
        }

        return new JsonResponse(sprintf('Delete %d OK', $domainId));
    }
}
