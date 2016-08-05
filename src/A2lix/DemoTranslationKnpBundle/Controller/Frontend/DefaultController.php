<?php

namespace A2lix\DemoTranslationKnpBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Method("GET")
     * @Route("/", name="knp_home")
     */
    public function indexAction()
    {
        return $this->render('demo_translation/knp/frontend/default/index.html.twig');
    }
}
