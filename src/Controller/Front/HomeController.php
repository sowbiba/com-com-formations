<?php

namespace App\Controller\Front;

use App\Entity\Domain;
use App\Manager\DomainsManager;
use App\Manager\HomeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var DomainsManager
     */
    private $domainsManager;
    /**
     * @var HomeManager
     */
    private $homeManager;

    public function __construct(
        DomainsManager $domainsManager,
        HomeManager $homeManager
    ) {
        $this->domainsManager = $domainsManager;
        $this->homeManager = $homeManager;
    }

    /**
     * @Route("/", name="app_front_home")
     */
    public function index(Request $request)
    {
        $home = $this->homeManager->find()[0];

        $displayableDomains = [];
        /**
         * @var Domain $domain
         */
        foreach ($this->domainsManager->find() as $domain) {
            if (0 < $domain->getFormations()->count()) {
                $displayableDomains[] = $domain;
            }
        }

        return $this->render('front/index.html.twig', [
            'domains' => $displayableDomains,
            'content' => $home,
        ]);
    }
}
