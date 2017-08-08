<?php

namespace PierreBonsPlansBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PierreBonsPlansBundle:Default:index.html.twig');
    }
}
