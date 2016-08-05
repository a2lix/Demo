<?php

namespace A2lix\DemoTranslationA2lixBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Method("GET")
     * @Route("/", name="a2lix_home")
     */
    public function indexAction()
    {
        return $this->render('demo_translation/a2lix/frontend/default/index.html.twig');
    }
}
