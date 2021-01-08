<?php

namespace App\Controller\Front;

use App\Entity\Domain;
use App\Entity\Encart;
use App\Entity\NewsletterEmail;
use App\Manager\DomainsManager;
use App\Manager\EncartsManager;
use App\Manager\NewsletterEmailManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommonController extends AbstractController
{
    /**
     * @var DomainsManager
     */
    private $domainsManager;
    /**
     * @var EncartsManager
     */
    private $encartsManager;
    /**
     * @var NewsletterEmailManager
     */
    private $newsletterEmailManager;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        DomainsManager $domainsManager,
        EncartsManager $encartsManager,
        NewsletterEmailManager $newsletterEmailManager,
        ValidatorInterface $validator
    ) {
        $this->domainsManager = $domainsManager;
        $this->encartsManager = $encartsManager;
        $this->newsletterEmailManager = $newsletterEmailManager;
        $this->validator = $validator;
    }

    public function menu(Request $request)
    {
        $displayableDomains = [];
        /**
         * @var Domain $domain
         */
        foreach ($this->domainsManager->find() as $domain) {
            if (0 < $domain->getFormations()->count()) {
                $displayableDomains[] = $domain;
            }
        }

        return $this->render('front/menu.html.twig', [
            'domains' => $displayableDomains,
        ]);
    }

    public function sidebar(Request $request)
    {
        $displayableEncarts = [];
        /**
         * @var Encart $encart
         */
        foreach ($this->encartsManager->find() as $encart) {
            if (!empty($encart->getTitle())) {
                $displayableEncarts[] = $encart;
            }
        }

        return $this->render('front/sidebar.html.twig', [
            'encarts' => $displayableEncarts,
        ]);
    }

    /**
     * @Route(
     *     "/newsletter/subscribe",
     *     name="app_front_newsletter_email_submit",
     *     methods={"POST"},
     *     condition="request.isXmlHttpRequest()",
     *     options = {"expose"=true},
     * )
     */
    public function subscribeNewsletter(Request $request)
    {
        $email = $request->request->get('email');
        if (empty($email)) {
            return new JsonResponse('Incorrect email value given', Response::HTTP_BAD_REQUEST);
        }

        $emailConstraint = new Email();
        $emailConstraint->message = 'Incorrect email value given';
        $errors = $this->validator->validate(
            $email,
            $emailConstraint
        );

        if ($errors->count() > 0) {
            return new JsonResponse('Incorrect email value given', Response::HTTP_BAD_REQUEST);
        }

        $existentEmails = $this->newsletterEmailManager->find(['email' => $email]);

        if (count($existentEmails) > 0) {
            $newsletterEmail = $existentEmails[0];
        } else {
            $newsletterEmail = new NewsletterEmail();
            $newsletterEmail->setEmail($email);
        }

        $newsletterEmail->setSubscribedAt(new \DateTime());

        $this->newsletterEmailManager->save($newsletterEmail);

        return new JsonResponse('Email successfully saved');
    }

    /**
     * @Route(
     *     "/contact",
     *     name="app_front_contact"
     * )
     */
    public function contact(Request $request)
    {
        return $this->render('front/contact.html.twig', [
        ]);
    }
}
