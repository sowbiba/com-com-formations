<?php

namespace App\Controller\Admin;

use App\Entity\Home;
use App\Form\HomeType;
use App\Manager\HomeManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    /**
     * @var HomeManager
     */
    private $homeManager;
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        HomeManager $homeManager,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        $this->homeManager = $homeManager;
        $this->translator = $translator;
        $this->logger = $logger;
    }

    /**
     * @Route("/home", name="app_admin_home")
     */
    public function index(Request $request)
    {
        $home = $this->homeManager->find()[0];

        $form = $this->createForm(HomeType::class, $home);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Home $home */
            $home = $form->getData();

            try {
                $this->homeManager->save($home);

                $this->addFlash('success', $this->translator->trans('Home content successfully updated'));
            } catch (\Exception $exception) {
                $this->logger->error(
                    'An error occurred during the home save',
                    [
                        'exception_type' => get_class($exception),
                        'exception_message' => $exception->getMessage(),
                        'exception_file' => $exception->getFile(),
                        'exception_line' => $exception->getLine(),
                    ]
                );

                $this->addFlash('error', 'Cannot save home');
            }

            return $this->redirectToRoute('app_admin_home');
        }

        return $this->render('admin/home/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
