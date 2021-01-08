<?php

namespace App\Controller\Front;

use App\Entity\Domain;
use App\DTO\Domain as DomainDTO;
use App\DTO\Formation as FormationDTO;
use App\Entity\Formation;
use App\Manager\DomainsManager;
use App\Manager\FormationsManager;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends AbstractController
{
    public const PAGE_LIMIT = 10;
    /**
     * @var DomainsManager
     */
    private $domainsManager;
    /**
     * @var FormationsManager
     */
    private $formationsManager;

    public function __construct(
        DomainsManager $domainsManager,
        FormationsManager $formationsManager
    ) {
        $this->domainsManager = $domainsManager;
        $this->formationsManager = $formationsManager;
    }

    /**
     * @Route("/formations", name="app_front_formations")
     */
    public function allFormations(Request $request)
    {
        $page = $request->query->get('page', 1);
        $formations = [];
        foreach ($this->formationsManager->find() as $formation) {
            $formations[] = new FormationDTO($formation);
        }

        $adapter = new ArrayAdapter($formations);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(self::PAGE_LIMIT);
        $pagerfanta->setCurrentPage($page);

        return $this->render('front/formations/index.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }

    /**
     * @Route("/domains/{slug}", name="app_front_domain")
     */
    public function domain(Request $request, string $slug)
    {
        if (empty($slug)) {
            $this->redirectToRoute('app_front_home');
        }

        $domains = $this->domainsManager->find(['slug' => $slug]);
        if (empty($domains)) {
            $this->redirectToRoute('app_front_home');
        }

        $page = $request->query->get('page', 1);

        /** @var Domain $domain */
        $domain = $domains[0];
        $formations = (new DomainDTO($domain))->getFormations();

        $adapter = new ArrayAdapter($formations);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(self::PAGE_LIMIT);
        $pagerfanta->setCurrentPage($page);

        return $this->render('front/domains/index.html.twig', [
            'pager' => $pagerfanta,
            'domain' => $domain,
        ]);
    }

    /**
     * @Route("/formations/{slug}", name="app_front_formations_view")
     */
    public function viewFormation(Request $request, string $slug)
    {
        if (empty($slug)) {
            $this->redirectToRoute('app_front_home');
        }

        $formations = $this->formationsManager->find(['slug' => $slug]);
        if (empty($formations)) {
            $this->redirectToRoute('app_front_home');
        }

        /** @var Formation $formation */
        $formation = $formations[0];
        $formation = new FormationDTO($formation);

        return $this->render('front/formations/view.html.twig', [
            'formation' => $formation,
        ]);
    }
}
