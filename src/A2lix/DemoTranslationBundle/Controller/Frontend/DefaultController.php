<?php

namespace A2lix\DemoTranslationBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Method("GET")
     * @Route("/translation", name="translation_home")
     */
    public function indexAction()
    {
        return $this->render('demo_translation/frontend/index.html.twig');
    }
}
