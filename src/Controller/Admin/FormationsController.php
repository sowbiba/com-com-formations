<?php

namespace App\Controller\Admin;

use App\Entity\Domain;
use App\Entity\Formation;
use App\Entity\FormationDate;
use App\Entity\FormationFile;
use App\Entity\FormationSection;
use App\Entity\Intervenant;
use App\Entity\Section;
use App\Form\FormationsFilterType;
use App\Form\FormationType;
use App\Manager\DomainsManager;
use App\Manager\FormationsManager;
use App\Manager\IntervenantsManager;
use App\Manager\SectionsManager;
use App\Uploader\FileUploader;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class FormationsController extends AbstractController
{
    /**
     * @var FormationsManager
     */
    private $formationsManager;
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var IntervenantsManager
     */
    private $intervenantsManager;
    /**
     * @var SectionsManager
     */
    private $sectionsManager;
    /**
     * @var DomainsManager
     */
    private $domainsManager;
    /**
     * @var FileUploader
     */
    private $fileUploader;

    public function __construct(
        FormationsManager $formationsManager,
        IntervenantsManager $intervenantsManager,
        DomainsManager $domainsManager,
        SectionsManager $sectionsManager,
        FileUploader $fileUploader,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        $this->formationsManager = $formationsManager;
        $this->intervenantsManager = $intervenantsManager;
        $this->sectionsManager = $sectionsManager;
        $this->domainsManager = $domainsManager;
        $this->fileUploader = $fileUploader;
        $this->translator = $translator;
        $this->logger = $logger;
    }

    /**
     * @Route("/formations", name="app_admin_formations")
     */
    public function index(Request $request)
    {
        $filterForm = $this->createForm(FormationsFilterType::class);
        $filterForm->handleRequest($request);

        $page = $request->query->get('page', 1);
        $sortField = $request->query->get('sort', 'id');
        $sortDirection = $request->query->get('direction', 'DESC');
        $criteria = $filterForm->isSubmitted() ? array_filter($filterForm->getData()) : [];

        $pager = $this->formationsManager->search($criteria, [$sortField => $sortDirection], $page);

        return $this->render('admin/formations/index.html.twig', [
            'pager' => $pager,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'filterForm' => $filterForm->createView(),
        ]);
    }

    /**
     * @Route("/formations/new", name="app_admin_formations_create")
     */
    public function create(Request $request)
    {
        $form = $this->createForm(FormationType::class, null, ['attr' => ['novalidate' => 'novalidate']]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Formation $formation */
            $formation = $form->getData();

            try {
                $this->formationsManager->save($formation);

                $this->addFlash('success', $this->translator->trans('Formation successfully saveddd'));

                return $this->redirectToRoute('app_admin_formations_domains', ['id' => $formation->getId()]);
            } catch (\Exception $exception) {
                $this->logger->error('Cannot save formation', [
                    'exception_message' => $exception->getMessage(),
                    'exception_file' => $exception->getFile(),
                    'exception_line' => $exception->getLine(),
                ]);

                $this->addFlash('error', $this->translator->trans('An error occurred when saving'));

                return $this->redirectToRoute('app_admin_formations');
            }
        }

        return $this->render('admin/formations/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/formations/{id}/edit", name="app_admin_formations_edit")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function edit(Request $request, Formation $formation)
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Formation $formation */
            $formation = $form->getData();

            try {
                $this->formationsManager->save($formation);

                $this->addFlash('success', $this->translator->trans('Formation #%id% successfully updated', ['%id%' => $formation->getId()]));

                return $this->redirectToRoute('app_admin_formations_domains', ['id' => $formation->getId()]);
            } catch (\Exception $exception) {
                $this->logger->error(
                    'An error occurred during the formation save. Check if attributes are unique',
                    [
                        'exception_type' => get_class($exception),
                        'exception_message' => $exception->getMessage(),
                        'exception_file' => $exception->getFile(),
                        'exception_line' => $exception->getLine(),
                    ]
                );

                $this->addFlash('error', 'Cannot save formation');
            }
        }

        return $this->render('admin/formations/edit.html.twig', [
            'form' => $form->createView(),
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/formations/{id}", name="app_admin_formations_delete", methods={"DELETE"}, condition="request.isXmlHttpRequest()")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function delete(Request $request, Formation $formation)
    {
        $formationId = $formation->getId();
        try {
            $this->formationsManager->delete($formation);

            $this->addFlash('success', sprintf('Formation #%d successfully deleted', $formationId));
        } catch (\Exception $exception) {
            $this->logger->error('Cannot delete formation', [
                'exception_message' => $exception->getMessage(),
                'exception_file' => $exception->getFile(),
                'exception_line' => $exception->getLine(),
            ]);

            $this->addFlash('error', 'Cannot delete formation');
        }

        return new JsonResponse(sprintf('Delete %d OK', $formationId));
    }

    /**
     * @Route("/formations/{id}/intervenants", name="app_admin_formations_intervenants")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function editFormationIntervenants(Request $request, Formation $formation)
    {
        $sortField = $request->query->get('sort', 'id');
        $sortDirection = $request->query->get('direction', 'DESC');

        $formationIntervenants = $formation->getIntervenants();
        $formationIntervenantsIds = array_map(function (Intervenant $formationIntervenant) {
            return $formationIntervenant->getId();
        }, $formationIntervenants->toArray());
        $intervenants = [];

        /** @var Intervenant $intervenant */
        foreach ($this->intervenantsManager->find() as $intervenant) {
            if (!in_array($intervenant->getId(), $formationIntervenantsIds)) {
                $key = sprintf('%s (%s)', $intervenant->getName(), $intervenant->getTitle());
                $intervenants[$key] = $intervenant->getId();
            }
        }

        $formBuilder = $this->createFormBuilder()
            ->add('intervenant', ChoiceType::class, [
                'choices' => $intervenants,
            ]);

        return $this->render('admin/formations/intervenants.html.twig', [
            'formation' => $formation,
            'addIntervenantForm' => $formBuilder->getForm()->createView(),
            'formationIntervenants' => $formation->getIntervenants(),
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * @Route("/formations/{id}/intervenants/link", name="app_admin_formations_intervenants_link")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function linkFormationIntervenant(Request $request, Formation $formation)
    {
        $intervenantId = $request->request->get('form')['intervenant'];

        if (!$intervenantId) {
            $this->addFlash('error', 'Intervenant not given');

            return $this->redirectToRoute('app_admin_formations_intervenants', ['id' => $formation->getId()]);
        }

        $intervenant = $this->intervenantsManager->findById($intervenantId);
        if (!$intervenant) {
            $this->addFlash('error', 'Intervenant not found');

            return $this->redirectToRoute('app_admin_formations_intervenants', ['id' => $formation->getId()]);
        }

        try {
            $formation->addIntervenant($intervenant);
            $this->formationsManager->save($formation);

            $this->addFlash('success', $this->translator->trans('Formation #%id% successfully updated', ['%id%' => $formation->getId()]));
        } catch (\Exception $exception) {
            $this->logger->error(
                'An error occurred during the formation save. Check if attributes are unique',
                [
                    'exception_type' => get_class($exception),
                    'exception_message' => $exception->getMessage(),
                    'exception_file' => $exception->getFile(),
                    'exception_line' => $exception->getLine(),
                ]
            );

            $this->addFlash('error', 'Cannot save formation');
        }

        return $this->redirectToRoute('app_admin_formations_intervenants', ['id' => $formation->getId()]);
    }

    /**
     * @Route("/formations/{id}/intervenants/{intervenantId}/unlink", name="app_admin_formations_intervenants_unlink")
     * @ParamConverter("formation", class="App:Formation")
     * @ParamConverter("intervenant", class="App:Intervenant", options={"id" = "intervenantId"})
     */
    public function unlinkFormationIntervenant(Request $request, Formation $formation, Intervenant $intervenant)
    {
        try {
            $formation->removeIntervenant($intervenant);
            $this->formationsManager->save($formation);

            $this->addFlash(
                'success',
                sprintf('
                Intervenant #%d is successfully deleted from Formation #%d',
                    $intervenant->getId(),
                    $formation->getId()
                )
            );
        } catch (\Exception $exception) {
            $this->logger->error('Cannot unlink intervenant from formation', [
                'exception_message' => $exception->getMessage(),
                'exception_file' => $exception->getFile(),
                'exception_line' => $exception->getLine(),
            ]);

            $this->addFlash('error', 'Cannot unlink intervenant from formation');
        }

        return $this->redirectToRoute('app_admin_formations_intervenants', ['id' => $formation->getId()]);
    }

    /**
     * @Route("/formations/{id}/dates", name="app_admin_formations_dates")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function editFormationDates(Request $request, Formation $formation)
    {
        $sortField = $request->query->get('sort', 'date');
        $sortDirection = $request->query->get('direction', 'DESC');

        $formBuilder = $this->createFormBuilder()
            ->add('date', TextType::class, [
                'attr' => [
                    'class' => 'datepicker',
                ],
            ])
            ->add('hours', TextType::class)
            ->add('e_learning', CheckboxType::class, ['required' => false])
        ;

        return $this->render('admin/formations/dates.html.twig', [
            'formation' => $formation,
            'addDateForm' => $formBuilder->getForm()->createView(),
            'formationDates' => $formation->getFormationDates(),
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * @Route("/formations/{id}/dates/add", name="app_admin_formations_dates_add")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function addFormationDate(Request $request, Formation $formation)
    {
        $formData = $request->request->get('form');
        $date = $formData['date'];
        $hours = $formData['hours'];
        $eLearning = array_key_exists('e_learning', $formData) ? $formData['e_learning'] : 0;

        try {
            $formationDate = new FormationDate();
            $formationDate->setDate($date);
            $formationDate->setHours($hours);
            $formationDate->setELearning($eLearning);
            $formationDate->setFormation($formation);

            $formation->addFormationDate($formationDate);
            $this->formationsManager->save($formation);

            $this->addFlash('success', $this->translator->trans('Formation #%id% successfully updated', ['%id%' => $formation->getId()]));
        } catch (\Exception $exception) {
            $this->logger->error(
                'An error occurred during the formation save. Check if attributes are unique',
                [
                    'exception_type' => get_class($exception),
                    'exception_message' => $exception->getMessage(),
                    'exception_file' => $exception->getFile(),
                    'exception_line' => $exception->getLine(),
                ]
            );

            $this->addFlash('error', 'Cannot save formation');
        }

        return $this->redirectToRoute('app_admin_formations_dates', ['id' => $formation->getId()]);
    }

    /**
     * @Route("/formations/{id}/dates/{formationDateId}/delete", name="app_admin_formations_dates_delete")
     * @ParamConverter("formation", class="App:Formation")
     * @ParamConverter("formationDate", class="App:FormationDate", options={"id" = "formationDateId"})
     */
    public function deleteFormationDate(Request $request, Formation $formation, FormationDate $formationDate)
    {
        try {
            $formation->removeFormationDate($formationDate);
            $this->formationsManager->save($formation);

            $this->addFlash(
                'success',
                sprintf('
                Date is successfully deleted from Formation #%d',
                    $formation->getId()
                )
            );
        } catch (\Exception $exception) {
            $this->logger->error('Cannot delete date from formation', [
                'exception_message' => $exception->getMessage(),
                'exception_file' => $exception->getFile(),
                'exception_line' => $exception->getLine(),
            ]);

            $this->addFlash('error', 'Cannot delete date from formation');
        }

        return $this->redirectToRoute('app_admin_formations_dates', ['id' => $formation->getId()]);
    }

    /**
     * @Route("/formations/{id}/sections", name="app_admin_formations_sections")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function editFormationSections(Request $request, Formation $formation)
    {
        $sections = $this->sectionsManager->find();
        usort($sections, function (Section $a, Section $b) {
            return strcmp($a->getDefaultOrder(), $b->getDefaultOrder());
        });
        $formBuilder = $this->createFormBuilder();

        $formationSections = [];
        /** @var FormationSection $formationSection */
        foreach ($formation->getFormationSections()->toArray() as $formationSection) {
            $formationSections[$formationSection->getSection()->getId()] = $formationSection;
        }
        /** @var Section $section */
        foreach ($sections as $section) {
            $value = '';
            if (array_key_exists($section->getId(), $formationSections)) {
                $value = $formationSections[$section->getId()]->getContent();
            }
            $formBuilder->add(
                sprintf('section_%s', $section->getId()),
                TextareaType::class,
                [
                    'attr' => [
                        'data-section-id' => $section->getId(),
                    ],
                    'label' => $section->getTitle(),
                    'required' => false,
                    'data' => $value,
                ]
            );
        }
        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sectionsData = $form->getData();

            foreach ($sectionsData as $sectionSlug => $value) {
                preg_match('/section_(?P<sectionId>\d+)/', $sectionSlug, $matches);
                if (!array_key_exists('sectionId', $matches) || !is_numeric($matches['sectionId'])) {
                    $this->addFlash('error', 'One of the section submitted is unknown first');

                    return $this->redirectToRoute('app_admin_formations_sections', ['id' => $formation->getId()]);
                }
                $sectionId = (int) $matches['sectionId'];
                $section = $this->sectionsManager->findById($sectionId);
                if (!$section) {
                    $this->addFlash('error', 'One of the section submitted is unknown second '.$sectionId);

                    return $this->redirectToRoute('app_admin_formations_sections', ['id' => $formation->getId()]);
                }

                $formationSection = new FormationSection();
                $formationSection->setFormation($formation);
                $formationSection->setSection($section);
                $formationSection->setContent($value);
                $formationSection->setSectionOrder($section->getDefaultOrder());

                $formation->addFormationSection($formationSection);
            }

            $this->formationsManager->save($formation);

            $this->addFlash('success', $this->translator->trans('Formation #%id% successfully updated', ['%id%' => $formation->getId()]));

            return $this->redirectToRoute('app_admin_formations_files', ['id' => $formation->getId()]);
        }

        return $this->render('admin/formations/sections.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/formations/{id}/linked-formations", name="app_admin_formations_formations_linked")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function editFormationFormationsLinked(Request $request, Formation $formation)
    {
        $sortField = $request->query->get('sort', 'id');
        $sortDirection = $request->query->get('direction', 'DESC');

        $formationFormationsLinked = $formation->getFormationLinkeds();
        $formationFormationsLinkedIds = array_map(function (Formation $formationLinked) {
            return $formationLinked->getId();
        }, $formationFormationsLinked->toArray());
        $formationsLinked = [];

        /** @var Formation $formationToLink */
        foreach ($this->formationsManager->find() as $formationToLink) {
            if (
                !in_array($formationToLink->getId(), $formationFormationsLinkedIds)
                && $formationToLink->getId() !== $formation->getId()
            ) {
                $formationsLinked[$formationToLink->getTitle()] = $formationToLink->getId();
            }
        }

        $formBuilder = $this->createFormBuilder()
            ->add('formationLinked', ChoiceType::class, [
                'choices' => $formationsLinked,
            ]);

        return $this->render('admin/formations/formations_linked.html.twig', [
            'formation' => $formation,
            'addFormationLinkedForm' => $formBuilder->getForm()->createView(),
            'formationFormationsLinked' => $formation->getFormationLinkeds(),
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * @Route("/formations/{id}/linked-formations/link", name="app_admin_formations_formations_link")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function linkFormationFormationLinked(Request $request, Formation $formation)
    {
        $formationLinkedId = $request->request->get('form')['formationLinked'];

        if (!$formationLinkedId) {
            $this->addFlash('error', 'formationLinked not given');

            return $this->redirectToRoute('app_admin_formations_formations_linked', ['id' => $formation->getId()]);
        }

        $formationLinked = $this->formationsManager->findById($formationLinkedId);
        if (!$formationLinked) {
            $this->addFlash('error', 'formationLinked not found');

            return $this->redirectToRoute('app_admin_formations_formations_linked', ['id' => $formation->getId()]);
        }

        try {
            $formation->addFormationLinked($formationLinked);
            $this->formationsManager->save($formation);

            $this->addFlash('success', $this->translator->trans('Formation #%id% successfully updated', ['%id%' => $formation->getId()]));
        } catch (\Exception $exception) {
            $this->logger->error(
                'An error occurred during the formation save. Check if attributes are unique',
                [
                    'exception_type' => get_class($exception),
                    'exception_message' => $exception->getMessage(),
                    'exception_file' => $exception->getFile(),
                    'exception_line' => $exception->getLine(),
                ]
            );

            $this->addFlash('error', 'Cannot save formation');
        }

        return $this->redirectToRoute('app_admin_formations_formations_linked', ['id' => $formation->getId()]);
    }

    /**
     * @Route("/formations/{id}/linked-formations/{formationLinkedId}/unlink", name="app_admin_formations_formations_unlink")
     * @ParamConverter("formation", class="App:Formation")
     * @ParamConverter("linkedFormation", class="App:Formation", options={"id" = "formationLinkedId"})
     */
    public function unlinkFormationFormationLinked(Request $request, Formation $formation, Formation $linkedFormation)
    {
        try {
            $formation->removeFormationLinked($linkedFormation);
            $this->formationsManager->save($formation);

            $this->addFlash(
                'success',
                sprintf('
                Formation #%d is successfully unlinked from Formation #%d',
                    $linkedFormation->getId(),
                    $formation->getId()
                )
            );
        } catch (\Exception $exception) {
            $this->logger->error('Cannot unlink formation from formation', [
                'exception_message' => $exception->getMessage(),
                'exception_file' => $exception->getFile(),
                'exception_line' => $exception->getLine(),
            ]);

            $this->addFlash('error', 'Cannot unlink formation from formation');
        }

        return $this->redirectToRoute('app_admin_formations_formations_linked', ['id' => $formation->getId()]);
    }

    /**
     * @Route("/formations/{id}/domains", name="app_admin_formations_domains")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function editFormationDomains(Request $request, Formation $formation)
    {
        $formationDomains = $formation->getDomains();
        $formationDomainsIds = array_map(function (Domain $formationDomain) {
            return $formationDomain->getId();
        }, $formationDomains->toArray());

        $formBuilder = $this->createFormBuilder();

        /** @var Domain $domain */
        foreach ($this->domainsManager->find() as $domain) {
            $formBuilder->add(
                sprintf('domain_%s', $domain->getId()),
                CheckboxType::class,
                [
                    'attr' => [
                        'data-domain-id' => $domain->getId(),
                    ],
                    'label' => $domain->getTitle(),
                    'required' => false,
                    'data' => in_array($domain->getId(), $formationDomainsIds, true),
                ]
            );
        }
        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData() as $domainSlug => $value) {
                preg_match('/domain_(?P<domainId>\d+)/', $domainSlug, $matches);
                if (!array_key_exists('domainId', $matches) || !is_numeric($matches['domainId'])) {
                    $this->addFlash('error', 'One of the domain submitted is unknown first');

                    return $this->redirectToRoute('app_admin_formations_domains', ['id' => $formation->getId()]);
                }
                $domainId = (int) $matches['domainId'];
                $domain = $this->domainsManager->findById($domainId);
                if (!$domain) {
                    $this->addFlash('error', 'One of the domain submitted is unknown second '.$domainId);

                    return $this->redirectToRoute('app_admin_formations_domains', ['id' => $formation->getId()]);
                }

                if (true === $value) {
                    $formation->addDomain($domain);
                } else {
                    $formation->removeDomain($domain);
                }
            }

            $this->formationsManager->save($formation);

            $this->addFlash('success', $this->translator->trans('Formation #%id% successfully updated', ['%id%' => $formation->getId()]));

            return $this->redirectToRoute('app_admin_formations_intervenants', ['id' => $formation->getId()]);
        }

        return $this->render('admin/formations/domains.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/formations/{id}/files", name="app_admin_formations_files")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function editFormationFiles(Request $request, Formation $formation)
    {
        $sortField = $request->query->get('sort', 'formation.title');
        $sortDirection = $request->query->get('direction', 'DESC');

        $formBuilder = $this->createFormBuilder()
            ->add('file', FileType::class)
            ->add('fancyName', TextType::class)
        ;

        return $this->render('admin/formations/files.html.twig', [
            'formation' => $formation,
            'addFileForm' => $formBuilder->getForm()->createView(),
            'formationFiles' => $formation->getFormationFiles(),
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * @Route("/formations/{id}/files/add", name="app_admin_formations_files_add")
     * @ParamConverter("formation", class="App:Formation")
     */
    public function addFormationFile(Request $request, Formation $formation)
    {
        try {
            $formFiles = $request->files->get('form');
            $formData = $request->request->get('form');
            if (is_array($formFiles) && array_key_exists('file', $formFiles) && $formFiles['file'] instanceof UploadedFile) {
                $fileName = $this->fileUploader->upload($formFiles['file']);

                $formationFile = new FormationFile();
                $formationFile->setFile($fileName);
                $formationFile->setFancyName(isset($formData['fancyName']) ? $formData['fancyName'] : 'Fichier');
                $formationFile->setFormation($formation);

                $formation->addFormationFile($formationFile);
                $this->formationsManager->save($formation);

                $this->addFlash('success', $this->translator->trans('Formation #%id% successfully updated', ['%id%' => $formation->getId()]));
            }
        } catch (\Exception $exception) {
            $this->logger->error(
                'An error occurred during the formation save. Check if attributes are unique',
                [
                    'exception_type' => get_class($exception),
                    'exception_message' => $exception->getMessage(),
                    'exception_file' => $exception->getFile(),
                    'exception_line' => $exception->getLine(),
                ]
            );

            $this->addFlash('error', 'Cannot save formation : '.$exception->getMessage());
        }

        return $this->redirectToRoute('app_admin_formations_files', ['id' => $formation->getId()]);
    }

    /**
     * @Route("/formations/{id}/files/{formationFileId}/delete", name="app_admin_formations_files_delete")
     * @ParamConverter("formation", class="App:Formation")
     * @ParamConverter("formationFile", class="App:FormationFile", options={"id" = "formationFileId"})
     */
    public function deleteFormationFile(Request $request, Formation $formation, FormationFile $formationFile)
    {
        try {
            $formation->removeFormationFile($formationFile);
            $this->formationsManager->save($formation);

            $this->addFlash(
                'success',
                sprintf('
                File is successfully deleted from Formation #%d',
                    $formation->getId()
                )
            );
        } catch (\Exception $exception) {
            $this->logger->error('Cannot delete date from formation', [
                'exception_message' => $exception->getMessage(),
                'exception_file' => $exception->getFile(),
                'exception_line' => $exception->getLine(),
            ]);

            $this->addFlash('error', 'Cannot delete date from formation');
        }

        return $this->redirectToRoute('app_admin_formations_files', ['id' => $formation->getId()]);
    }
}
