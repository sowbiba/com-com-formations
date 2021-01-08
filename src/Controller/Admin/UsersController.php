<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UsersFilterType;
use App\Form\UserType;
use App\Security\Manager\UserManager;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class UsersController extends AbstractController
{
    /**
     * @var UserManager
     */
    private $usersManager;
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        UserManager $usersManager,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        $this->usersManager = $usersManager;
        $this->translator = $translator;
        $this->logger = $logger;
    }

    /**
     * @Route("/users", name="app_admin_users")
     */
    public function index(Request $request)
    {
        $filterForm = $this->createForm(UsersFilterType::class);
        $filterForm->handleRequest($request);

        $page = $request->query->get('page', 1);
        $sortField = $request->query->get('sort', 'id');
        $sortDirection = $request->query->get('direction', 'DESC');
        $criteria = $filterForm->isSubmitted() ? array_filter($filterForm->getData()) : [];

        $pager = $this->usersManager->search($criteria, [$sortField => $sortDirection], $page);

        return $this->render('admin/users/index.html.twig', [
            'pager' => $pager,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'filterForm' => $filterForm->createView(),
        ]);
    }

    /**
     * @Route("/users/{id}/edit", name="app_admin_users_edit")
     * @ParamConverter("user", class="App:User")
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            try {
                $this->usersManager->save($user);

                $this->addFlash('success', $this->translator->trans('User #%id% successfully updated', ['%id%' => $user->getId()]));
            } catch (\Exception $exception) {
                $this->logger->error(
                    'An error occurred during the user save. Check if attributes are unique',
                    [
                        'exception_type' => get_class($exception),
                        'exception_message' => $exception->getMessage(),
                        'exception_file' => $exception->getFile(),
                        'exception_line' => $exception->getLine(),
                    ]
                );

                $this->addFlash('error', 'Cannot save user');
            }

            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/users/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/users/{id}", name="app_admin_users_delete", methods={"DELETE"}, condition="request.isXmlHttpRequest()")
     * @ParamConverter("user", class="App:User")
     */
    public function delete(Request $request, User $user)
    {
        $userId = $user->getId();
        try {
            $this->usersManager->delete($user);

            $this->addFlash('success', sprintf('User #%d successfully deleted', $userId));
        } catch (\Exception $exception) {
            $this->logger->error('Cannot delete user', [
                'exception_message' => $exception->getMessage(),
                'exception_file' => $exception->getFile(),
                'exception_line' => $exception->getLine(),
            ]);

            $this->addFlash('error', 'Cannot delete user');
        }

        return new JsonResponse(sprintf('Delete %d OK', $userId));
    }
}
