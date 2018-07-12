<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Session $session)
    {
        if ($session->get('connected') !== true) {
            $session->set('connected', false);
        }
        return $this->render('index.html.twig');
    }
}
