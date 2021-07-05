<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    /**
     * @Route("/page/1", name="app_page_1")
     * @Method("GET")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAGE_1')")
     */
    public function appPage1(): Response
    {
        return $this->render('page/index.html.twig', [
            'username' => $this->getUser()->getUsername(),
            'page' => '1',
        ]);
    }
    
    /**
     * @Route("/page/2", name="app_page_2")
     * @Method("GET")
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_PAGE_2')")
     */
    public function appPage2(): Response
    {
        return $this->render('page/index.html.twig', [
            'username' => $this->getUser()->getUsername(),
            'page' => '2',
        ]);
    }
}
